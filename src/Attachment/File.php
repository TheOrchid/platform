<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Contracts\Engine;
use Orchid\Attachment\Engines\Generator;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Events\ReplicateFileEvent;
use Orchid\Platform\Events\UploadFileEvent;
use Orchid\Support\Facades\Dashboard;

/**
 * This class represents an uploaded file that can be saved to the disk
 */
class File
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var Filesystem
     */
    protected $storage;

    /**
     * @var string
     */
    protected $disk;

    /**
     * @var string|null
     */
    protected $group;

    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var bool
     */
    protected $duplicate = false;

    /**
     * Class constructor
     *
     * @param UploadedFile $file  - the uploaded file object to store
     * @param string       $disk  - the disk to use for storage (defaults to the 'public' disk from the config)
     * @param string       $group - the group to associate the file with
     */
    public function __construct(UploadedFile $file, ?string $disk = null, ?string $group = null)
    {
        // Abort the process if the file does not have an observable size
        abort_if($file->getSize() === false, 415, 'File failed to load.');

        $this->file = $file;
        $this->disk = $disk ?? config('platform.attachment.disk', 'public'); // get the disk to use from the config or use the default 'public' disk
        $this->storage = Storage::disk($this->disk);

        /** @var string $generator */
        $generator = config('platform.attachment.generator', Generator::class);

        // Create a new engine class instance to manage the file's associations
        $this->engine = new $generator($file);
        $this->group = $group;
    }

    /**
     * Load the file and either create a new entry or retrieve
     * an already stored entry matching the hash of the file
     *
     * @throws \League\Flysystem\FilesystemException
     *
     * @return Model|Attachment
     */
    public function load(): Model
    {
        $attachment = $this->getMatchesHash();

        if ($attachment === null) {
            return $this->save();
        }

        $attachment = $attachment->replicate()->fill([
            'original_name' => $this->file->getClientOriginalName(),
            'sort'          => 0,
            'user_id'       => Auth::id(),
            'group'         => $this->group,
        ]);

        $attachment->save();

        event(new ReplicateFileEvent($attachment, $this->engine->time()));

        return $attachment;
    }

    /**
     * Allow duplicates of the file
     *
     * @param bool $status - The status to allow/disable the duplicates
     *
     * @return $this
     */
    public function allowDuplicates(bool $status = true): self
    {
        $this->duplicate = $status;

        return $this;
    }

    /**
     * Retrieve an already stored entry matching the hash of the file
     *
     * @return Attachment|null
     */
    private function getMatchesHash()
    {
        if ($this->duplicate) {
            return null;
        }

        return Dashboard::model(Attachment::class)::where('hash', $this->engine->hash())
            ->where('disk', $this->disk)
            ->first();
    }

    /**
     * Save the file to disk and create an attachment entry in the db
     *
     * @return Model|Attachment
     */
    private function save(): Model
    {
        $this->storage->putFileAs($this->engine->path(), $this->file, $this->engine->fullName(), [
            'mime_type' => $this->engine->mime(),
        ]);

        $attachment = Dashboard::model(Attachment::class)::create([
            'name'          => $this->engine->name(),
            'mime'          => $this->engine->mime(),
            'hash'          => $this->engine->hash(),
            'extension'     => $this->engine->extension(),
            'original_name' => $this->file->getClientOriginalName(),
            'size'          => $this->file->getSize(),
            'path'          => Str::finish($this->engine->path(), '/'),
            'disk'          => $this->disk,
            'group'         => $this->group,
            'user_id'       => Auth::id(),
        ]);

        event(new UploadFileEvent($attachment, $this->engine->time()));

        return $attachment;
    }

    /**
     * Set a custom path for the file
     *
     * @param string|null $path - The custom path to use for this file
     *
     * @return File
     */
    public function path(?string $path = null)
    {
        $this->engine->setPath($path);

        return $this;
    }
}
