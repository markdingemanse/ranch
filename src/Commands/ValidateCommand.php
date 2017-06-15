<?php

namespace Liquidpineapple\Ranch\Commands;

use Liquidpineapple\Ranch\Config;
use Liquidpineapple\Ranch\ConfigFiles\HomesteadConfig;
use Liquidpineapple\Ranch\ConfigFiles\HostsConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Collection;

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
        $errors = collect();
        $hostsFileHosts = HostsConfig::getSites();
        $homesteadHosts = HomesteadConfig::getSites();

        // Find missing sites
        $commonHosts = $this->getCommon($hostsFileHosts, $homesteadHosts);
        $hostsFileHosts->each(function($site) use ($errors, $commonHosts) {
            if (!$commonHosts->contains($site)) {
                $errors->push($site . ' is not in your Homestead.yaml');
            }
        });
        $homesteadHosts->each(function($site) use ($errors, $commonHosts) {
            if (!$commonHosts->contains($site)) {
                $errors->push($site . ' is not in your Hosts file');
            }
        });

        if ($errors->count() === 0) {
            $io->success("Congratz, everything is configured correctly!");
        } else {
            $io->warning("Uh oh! The following seems to be wrong with your configuration:");
            $io->listing($errors->toArray());
        }
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
