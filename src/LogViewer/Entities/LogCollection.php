<?php

namespace Orchid\LogViewer\Entities;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Orchid\LogViewer\Exceptions\LogNotFoundException;
use Orchid\LogViewer\Contracts\Utilities\Filesystem as FilesystemContract;

/**
 * Class     LogCollection.
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogCollection extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var \Orchid\LogViewer\Contracts\Utilities\Filesystem */
    private $filesystem;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * LogCollection constructor.
     *
     * @param  array $items
     */
    public function __construct($items = [])
    {
        $this->setFilesystem(app('arcanedev.log-viewer.filesystem'));

        parent::__construct($items);

        if (empty($items)) {
            $this->load();
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Set the filesystem instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\Filesystem $filesystem
     *
     * @return \Orchid\LogViewer\Entities\LogCollection
     */
    public function setFilesystem(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Load all logs.
     *
     * @return \Orchid\LogViewer\Entities\LogCollection
     */
    private function load()
    {
        foreach ($this->filesystem->dates(true) as $date => $path) {
            $log = Log::make($date, $path, $this->filesystem->read($date));

            $this->put($date, $log);
        }

        return $this;
    }

    /**
     * Paginate logs.
     *
     * @param  int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 30)
    {
        $request = request();
        $currentPage = $request->input('page', 1);
        $paginator = new LengthAwarePaginator(
            $this->slice(($currentPage * $perPage) - $perPage, $perPage),
            $this->count(),
            $perPage,
            $currentPage
        );

        return $paginator->setPath($request->url());
    }

    /**
     * Get a log (alias).
     *
     * @see get()
     *
     * @param  string $date
     *
     * @return \Orchid\LogViewer\Entities\Log
     */
    public function log($date)
    {
        return $this->get($date);
    }

    /**
     * Get a log.
     *
     * @param  string $date
     * @param  mixed|null $default
     *
     * @return \Orchid\LogViewer\Entities\Log
     *
     * @throws \Orchid\LogViewer\Exceptions\LogNotFoundException
     */
    public function get($date, $default = null)
    {
        if (! $this->has($date)) {
            throw new LogNotFoundException("Log not found in this date [$date]");
        }

        return parent::get($date, $default);
    }

    /**
     * Get log entries.
     *
     * @param  string $date
     * @param  string $level
     *
     * @return \Orchid\LogViewer\Entities\LogEntryCollection
     */
    public function entries($date, $level = 'all')
    {
        return $this->get($date)->entries($level);
    }

    /**
     * Get logs statistics.
     *
     * @return array
     */
    public function stats()
    {
        $stats = [];

        foreach ($this->items as $date => $log) {
            /* @var \Orchid\LogViewer\Entities\Log $log */
            $stats[$date] = $log->stats();
        }

        return $stats;
    }

    /**
     * List the log files (dates).
     *
     * @return array
     */
    public function dates()
    {
        return $this->keys()->toArray();
    }

    /**
     * Get entries total.
     *
     * @param  string $level
     *
     * @return int
     */
    public function total($level = 'all')
    {
        return (int) $this->sum(function (Log $log) use ($level) {
            return $log->entries($level)->count();
        });
    }

    /**
     * Get logs tree.
     *
     * @param  bool $trans
     *
     * @return array
     */
    public function tree($trans = false)
    {
        $tree = [];

        foreach ($this->items as $date => $log) {
            /* @var \Orchid\LogViewer\Entities\Log $log */
            $tree[$date] = $log->tree($trans);
        }

        return $tree;
    }

    /**
     * Get logs menu.
     *
     * @param  bool $trans
     *
     * @return array
     */
    public function menu($trans = true)
    {
        $menu = [];

        foreach ($this->items as $date => $log) {
            /* @var \Orchid\LogViewer\Entities\Log $log */
            $menu[$date] = $log->menu($trans);
        }

        return $menu;
    }
}
