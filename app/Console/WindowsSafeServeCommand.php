<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\Collection;
use Symfony\Component\Process\Process;

use function Illuminate\Support\php_binary;

/**
 * Windows-safe replacement for Laravel's `serve` command.
 *
 * On Windows, stripping $_ENV in the child PHP process (default ServeCommand behaviour
 * when .env exists) prevents the built-in server from binding to a port.
 */
class WindowsSafeServeCommand extends ServeCommand
{
    public function handle(): int
    {
        set_time_limit(0);

        return parent::handle();
    }

    /**
     * @return array<int, string>
     */
    protected function serverCommand(): array
    {
        $router = public_path('server.php');

        if (is_file($router)) {
            return [
                php_binary(),
                '-S',
                $this->host().':'.$this->port(),
                str_replace('\\', '/', $router),
            ];
        }

        return parent::serverCommand();
    }

    /**
     * @param  bool  $hasEnvironment
     */
    protected function startProcess($hasEnvironment): Process
    {
        if (! windows_os()) {
            return parent::startProcess($hasEnvironment);
        }

        $environment = (new Collection($_ENV))
            ->merge([
                'PHP_CLI_SERVER_WORKERS' => $this->phpServerWorkers,
            ])
            ->filter(static fn ($value): bool => $value !== false)
            ->all();

        $process = new Process(
            $this->serverCommand(),
            public_path(),
            $environment,
        );

        $this->trap(fn () => [SIGTERM, SIGINT, SIGHUP, SIGUSR1, SIGUSR2, SIGQUIT], function ($signal) use ($process): void {
            if ($process->isRunning()) {
                $process->stop(10, $signal);
            }

            exit;
        });

        $process->start($this->handleProcessOutput());

        return $process;
    }
}
