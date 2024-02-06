<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StartApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run sail up and npm run dev';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running sail up...');
        $sailUp = Process::fromShellCommandline('./vendor/bin/sail up');
        $sailUp->run();

        if ($sailUp->getExitCode() !== 0) {
            $this->error('sail up failed with exit code: ' . $sailUp->getExitCode());
            return 1;
        }

        $this->info('Running npm run dev...');
        $npmDev = Process::fromShellCommandline('npm run dev &');
        $npmDev->run();


        $this->info('Successfully ran sail up and npm run dev');
        return 0;
    }
}
