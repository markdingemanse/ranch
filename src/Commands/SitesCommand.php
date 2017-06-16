<?php

namespace Liquidpineapple\Ranch\Commands;

use Illuminate\Support\Collection;
use Liquidpineapple\Ranch\Config;
use Liquidpineapple\Ranch\ConfigFiles\HomesteadConfig;
use Liquidpineapple\Ranch\ConfigFiles\HostsConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SitesCommand extends Command {

    protected function configure()
    {
        $this->setName('sites')
             ->setDescription('List all configured sites')
             ->setHelp('This command shows a list of all configured sites');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $hostsFileHosts = HostsConfig::getSites();
        $homesteadHosts = HomesteadConfig::getSites();
        $commonHosts = $this->getCommon($hostsFileHosts, $homesteadHosts)->toArray();

        $io->title('Configured sites');
        $io->listing($commonHosts);
    }

    /**
     * Takes two lists and returns the common items
     * @param Collection $listA first list of sites
     * @param Collection $listB second list of sites
     * @return Collection list of sites that lists A and B have in common
     */
    private function getCommon(Collection $listA, Collection $listB)
    {
        $filteredA = $listA->filter(function ($site) use ($listB) {
            return $listB->contains($site);
        });
        $filteredB = $listB->filter(function ($site) use ($filteredA) {
            return $filteredA->contains($site);
        });
        return $filteredB;
    }

}
