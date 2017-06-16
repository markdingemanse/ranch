<?php

namespace Liquidpineapple\Ranch\Commands;

use Liquidpineapple\Ranch\Config;
use Liquidpineapple\Ranch\ConfigFiles\HomesteadConfig;
use Liquidpineapple\Ranch\ConfigFiles\HostsConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AddCommand extends Command {

    protected function configure()
    {
        $this->setName('add')
             ->addArgument('site', InputArgument::REQUIRED, 'Your site, e.g.: example.dev')
             ->setDescription('Add a new site to your configuration (setup)')
             ->setHelp('Add a new site to your configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $site = $input->getArgument('site');
        $project = explode('.', $site)[0];

        // 1. Remote serve path
        $defaultSitePath = "/home/vagrant/code/$project/public";
        $sitePath = $helper->ask($input, $output,
            new Question("\n 1. Homestead serve path ($defaultSitePath): ", $defaultSitePath)
        );

        // 2. Local path
        // TODO: add

        // Adding logic
        // $homesteadConfig = HomesteadConfig::get();
        // print_r($homesteadConfig);
    }

}
