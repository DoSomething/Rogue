<?php

namespace Rogue\Console\Commands;

use Illuminate\Console\Command;
use DFurnes\Environmentalist\ConfiguresApplication;

class SetupCommand extends Command
{
    use ConfiguresApplication;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rogue:setup {--reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure your application.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createEnvironmentFile($this->option('reset'));

        $this->section('Set Northstar environment variables', function () {
            $environments = [
                'http://northstar.test' => 'http://aurora.test',
                'https://identity-dev.dosomething.org' => 'https://admin-dev.dosomething.org',
                'https://identity-qa.dosomething.org' => 'https://admin-qa.dosomething.org',
            ];

            $this->chooseEnvironmentVariable('NORTHSTAR_URL', 'Choose a Northstar environment', array_keys($environments));

            $this->instruction('You can get these environment variables from Aurora\'s "Clients" page:');
            $this->instruction($environments[env('NORTHSTAR_URL')] . '/clients');

            $this->setEnvironmentVariable('NORTHSTAR_AUTH_ID', 'Enter the OAuth Client ID for web sessions');
            $this->setEnvironmentVariable('NORTHSTAR_AUTH_SECRET', 'Enter the OAuth Client Secret for web sessions');

            $this->setEnvironmentVariable('NORTHSTAR_CLIENT_ID', 'Enter the OAuth Client ID for machine requests');
            $this->setEnvironmentVariable('NORTHSTAR_CLIENT_SECRET', 'Enter the OAuth Client Secret for machine requests');
        });

        $this->line('Creating application key');
        $this->call('key:generate');

        $this->line('Fetching public key from Northstar');
        $this->call('gateway:key');

        $this->line('Running database migrations');
        $this->call('migrate');
    }
}
