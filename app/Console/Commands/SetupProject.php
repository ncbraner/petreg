<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class SetupProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the project by running composer install, sail up, migrate and db seed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running composer install...');
        $composer = Process::fromShellCommandline('composer install');
        $composer->mustRun();

        $this->info('Running npm install...');
        $npm = Process::fromShellCommandline('npm install');
        $npm->run();

        if ($npm->getExitCode() !== 0) {
            $this->error('npm install failed with exit code: ' . $npm->getExitCode());
        }

        $this->info('Running sail up...');
        $sailUp = Process::fromShellCommandline('./vendor/bin/sail up -d');
        $sailUp->mustRun();

        $this->info('Waiting for Docker containers to be ready...');
        sleep(90);  // Adjust this delay as needed

        $this->info('Running migrations...');
        $migrate = Process::fromShellCommandline('./vendor/bin/sail artisan migrate');
        $migrate->mustRun();

        $this->info('Seeding the breeds...');
        $seed = Process::fromShellCommandline('./vendor/bin/sail artisan db:seed --class=BreedsTableSeeder');
        $seed->mustRun();

        $this->info('Seeding the users...');
        $seed = Process::fromShellCommandline('./vendor/bin/sail artisan db:seed --class=UserSeeder');
        $seed->mustRun();

        $this->info('Running npm run dev...');
        $npmDev = Process::fromShellCommandline('npm run dev &');
        $npmDev->run();


        $this->info('Project setup completed.');

        return 0;
    }
}
