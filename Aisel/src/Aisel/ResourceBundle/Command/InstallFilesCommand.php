<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * InstallFilesCommand
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class InstallFilesCommand extends ContainerAwareCommand
{

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('aisel:install:files')
            ->setHelp(<<<EOT
The <info>aisel:install</info> Installs necessary files.
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<info>Installing directories & files ...</info>');
        $this->setupFiles($output);
        $output->writeln('<info>Done, without any issues ...</info>');
    }

    /**
     * installDependencies
     *
     * @param OutputInterface $output
     */
    protected function setupFiles(OutputInterface $output)
    {
        $fs = new Filesystem();
        $apiDir = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
        $frontendDir = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../frontend/web');
        $backendDir = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../backend/web');
        $mediaDir = $apiDir . $this->getContainer()->getParameter('application.media.path');

        // Frontend
        $fs->copy($frontendDir . '/robots.txt.dist', $frontendDir . '/robots.txt');
        $fs->copy($frontendDir . '/images/logo.png.dist', $frontendDir . '/images/logo.png');
        $fs->copy($frontendDir . '/.htaccess.dist', $frontendDir . '/.htaccess');

        // Backend
        $fs->copy($backendDir . '/.htaccess.dist', $backendDir . '/.htaccess');

        // Api
        $fs->copy($apiDir . '/.htaccess.dist', $apiDir . '/.htaccess');

        // Media
        if ($fs->exists($mediaDir) === false) {
            $fs->mkdir($mediaDir);
        }

    }

}
