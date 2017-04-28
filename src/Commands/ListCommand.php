<?php

namespace Liquidpineapple\Ranch\Commands;

use Liquidpineapple\Ranch\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class ListCommand extends Command {

    protected function configure()
    {
        $this->setName('list')
             ->setDescription('List all configured sites')
             ->setHelp('This command shows a list of all configured sites');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem;
        $output->writeln(Config::homedir());
        try {
            if ($fs->exists('$HOME/Homestead/Homestead.yaml')) {
                $output->writeln('mtndew');
            } else {
                $output->writeln('memes');
            }
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }
    }

}
