<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DockerDown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docker:down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run docker-compose down --volume';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running docker-compose down --volume...');
        $process = Process::fromShellCommandline('docker-compose down --volume');
        $process->run();

        if ($process->isSuccessful()) {
            $this->info('Successfully ran docker-compose down --volume.');
        } else {
            $this->error('Failed to run docker-compose down --volume. Error: ' . $process->getErrorOutput());
        }

        return 0;
    }
}
