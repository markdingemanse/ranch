<?php

namespace Liquidpineapple\Ranch\Commands;

use Liquidpineapple\Ranch\Config;
use Liquidpineapple\Ranch\ConfigFiles\HostsConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateCommand extends Command {

    protected function configure()
    {
        $this->setName('validate')
             ->setDescription('Validates your current setup')
             ->setHelp('Checks your hostsfile and Homestead.yaml, then checks if nothing is missing.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $hostsFileHosts = HostsConfig::get()
            ->filter(function($host) {
                return $host['ip_address'] === Config::homesteadIp();
            })
            ->map(function($host) {
                return $host['hostname'];
            })
            ->toArray();

    }

}
