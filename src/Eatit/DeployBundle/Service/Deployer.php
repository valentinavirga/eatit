<?php

namespace Eatit\DeployBundle\Service;

use JordiLlonch\Bundle\DeployBundle\Service\BaseDeployer;

class Deployer extends BaseDeployer
{
    public function downloadCode()
    {
        $this->logger->debug('Downloading code...');
        $this->output->writeln('<info>Downloading code...</info>');
        $this->downloadCodeVcs();

        $this->logger->debug('Adapting code');
        $this->output->writeln('<info>Adapting code...</info>');
        // Here you can download vendors, add productions configuration, 
        // do cache warm up, set shared directories...

        $this->logger->debug('Copying code to zones...');
        $this->output->writeln('<info>Copying code to zones...</info>');
        $this->code2Servers();
    }
    public function code2ProductionAfter()
    {
//        rm current
//        ln -s dir current
//        cd current
//        composer update
//        parametri db
        
        $currentDir = $this->getRemoteCurrentRepositoryDir();
        $codeDir = $this->getRemoteProductionCodeDir();
        //$this->execRemoteServers($sudo . 'rm "' . $dir . '/.."');
    }
    public function downloadCodeRollback()
    {
    }

    protected function runClearCache()
    {
        $this->logger->debug('Clearing cache...');
        $this->output->writeln('<info>Clearing cache...</info>');
        $this->execRemoteServers('sudo pkill -USR2 -o php-fpm');
    }
}