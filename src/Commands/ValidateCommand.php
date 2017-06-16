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

    /**
     * A collection of errors found in the enduser's environment
     * @var $errors Colleciton
     */
    private $errors;

    protected function configure()
    {
        $this->setName('validate')
             ->setDescription('Validates your current setup')
             ->setHelp('Checks your hostsfile and Homestead.yaml, then checks if nothing is missing.');
         $this->errors = collect();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->findSiteErrors();
        $this->findFolderErrors();

        if ($this->errors->count() === 0) {
            $io->success("Congratz, everything is configured correctly!");
        } else {
            $io->warning("Uh oh! The following seems to be wrong with your configuration:");
            $io->listing($this->errors->toArray());
        }
    }

    private function findSiteErrors()
    {
        // Get sites
        $hostsFileHosts = HostsConfig::getSites();
        $homesteadHosts = HomesteadConfig::getSites();

        // Get sites that config files have in common
        $commonHosts = $this->getCommon($hostsFileHosts, $homesteadHosts);

        // Report sites that are missing in either of the configs
        $hostsFileHosts->each(function($site) use ($commonHosts) {
            if (!$commonHosts->contains($site)) {
                $this->errors->push($site . ' is not in your Homestead.yaml');
            }
        });
        $homesteadHosts->each(function($site) use ($commonHosts) {
            if (!$commonHosts->contains($site)) {
                $this->errors->push($site . ' is not in your Hosts file');
            }
        });
    }

    private function findFolderErrors()
    {
        $syncPaths = HomesteadConfig::getRemoteSyncPaths();
        $sitePaths = HomesteadConfig::getRemoteSitePaths();
        $sitePaths->each(function($sitePath) use ($syncPaths) {
            $valid = false;
            foreach ($syncPaths as $key => $syncPath) {
                if (substr($sitePath, 0, strlen($syncPath)) === $syncPath) {
                    $valid = true;
                }
            }
            if (!$valid) {
                $this->errors->push('No files synced to ' . $sitePath);
            }
        });
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
