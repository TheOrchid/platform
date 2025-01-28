<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Conditionable;
use Orchid\Platform\Events\InstallEvent;
use Orchid\Platform\Providers\ConsoleServiceProvider;
use Orchid\Support\Facades\Dashboard;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:install')]
class InstallCommand extends Command
{
    use Conditionable;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'orchid:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Orchid files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Installation started. Please wait...');
        $this->info('Version: '.Dashboard::version());

        $this
            ->executeCommand('vendor:publish', [
                '--provider' => ConsoleServiceProvider::class,
                '--tag'      => [
                    'orchid-config',
                    'orchid-migrations',
                    'orchid-app-stubs',
                    'orchid-assets',
                ],
            ])
            ->executeCommand('migrate')
            ->executeCommand('storage:link')
            ->changeUserModel()
            ->setValueEnv('SCOUT_DRIVER')
            ->when(class_exists(\App\Models\User::class), function () {
                $this->replaceInFiles(app_path(), 'use Orchid\\Platform\\Models\\User;', 'use App\\Models\\User;');
            })
            ->showMeLove();

        $this->info('Completed!');
        $this->comment("To create a user, run 'artisan orchid:admin'");
        $this->line("To start the embedded server, run 'artisan serve'");

        event(new InstallEvent($this));
    }

    /**
     * @return $this
     */
    private function executeCommand(string $command, array $parameters = []): self
    {
        try {
            $result = $this->callSilent($command, $parameters);
        } catch (\Exception $exception) {
            $result = 1;
            $this->alert($exception->getMessage());
        }

        if ($result) {
            $parameters = http_build_query($parameters, '', ' ');
            $parameters = str_replace('%5C', '/', $parameters);
            $this->alert("An error has occurred. The '{$command} {$parameters}' command was not executed");
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function changeUserModel(string $path = 'Models/User.php'): self
    {
        $this->info('Attempting to set ORCHID User model as parent to App\User');

        if (! file_exists(app_path($path))) {
            $this->warn('Unable to locate "app/Models/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Change "extends Authenticatable" to "extends \Orchid\Platform\Models\User" in your User model');
            $this->warn('Also pay attention to the properties so that they are not overwritten.');

            return $this;
        }

        $user = file_get_contents(Dashboard::path('stubs/app/User.stub'));
        file_put_contents(app_path($path), $user);

        return $this;
    }

    private function setValueEnv(string $constant, string $value = 'null'): self
    {
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && ! str_contains($str, $constant)) {
            file_put_contents(app_path('../.env'), $str.PHP_EOL.$constant.'='.$value.PHP_EOL);
        }

        return $this;
    }

    /**
     * @return false|string
     */
    private function fileGetContent(string $file)
    {
        if (! is_file($file)) {
            return '';
        }

        return file_get_contents($file);
    }

    /**
     * @return $this
     */
    private function showMeLove(): self
    {
        if (App::runningUnitTests() || ! $this->confirm('Would you like to show a little love by starting with ⭐')) {
            return $this;
        }

        $repo = 'https://github.com/orchidsoftware/platform';

        match (PHP_OS_FAMILY) {
            'Darwin'  => exec('open '.$repo),
            'Windows' => exec('start '.$repo),
            'Linux'   => exec('xdg-open '.$repo),
            default   => $this->line('You can find us at '.$repo),
        };

        $this->line('Thank you! It means a lot to us! 🙏');

        return $this;
    }

    /**
     * @param string $directory
     * @param string $search
     * @param string $replace
     *
     * @return void
     */
    private function replaceInFiles(string $directory, string $search, string $replace): self
    {
        if (! is_dir($directory)) {
            return $this;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );

        // Iterate through all files in the directory
        foreach ($files as $file) {
            // Skip if not a .php file
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $filePath = $file->getRealPath();
            $fileContents = file_get_contents($filePath);

            // Skip if the file does not contain the old namespace
            if (! str_contains($fileContents, $search)) {
                continue;
            }

            // Replace the old namespace with the new one
            $updatedContents = str_replace($search, $replace, $fileContents);

            // Save the changes
            file_put_contents($filePath, $updatedContents);
        }

        return $this;
    }
}
