<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\InstallerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Install Aisel CMS
 * Command: "aisel:install"
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class InstallCommand extends ContainerAwareCommand
{

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('aisel:install')
            ->setHelp(<<<EOT
The <info>aisel:install</info> command launch installation process.
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>**************************************</info>');
        $output->writeln('<info>********** Installing Aisel **********</info>');
        $output->writeln('<info>**************************************</info>');
        $output->writeln('');

        $this->launchSetup($input, $output);
        $output->writeln('<info>Installation finished.</info>');
    }


    /**
     * Launch setup process
    */
    protected function launchSetup(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Database settings.</info>');

        if ($this->getHelperSet()->get('dialog')->askConfirmation($output, '<question>Create database (Y/N)?</question>', false)) {
            $this->createDatabase($input, $output);
        }
        $this->setupDatabase($input, $output);

        if ($this->getHelperSet()->get('dialog')->askConfirmation($output, '<question>Load fixtures (Y/N)?</question>', false)) {
            $this->loadFixtures($input, $output);
        }

        $output->writeln('');
        $output->writeln('<info>Backend user setup.</info>');

        $this->setupBackendUser($output);
        $this->setupFiles($output);

        $output->writeln('');

        return $this;
    }

    /**
     * Create database
     */
    protected function createDatabase(InputInterface $input, OutputInterface $output)
    {
        $this->runCommand('doctrine:database:create', $input, $output);
    }

    /**
     * Load demo data
     */
    protected function loadFixtures(InputInterface $input, OutputInterface $output)
    {
        $this->runCommand('doctrine:fixtures:load', $input, $output);
    }

    /**
     * Create Schema and install assets
     */
    protected function setupDatabase(InputInterface $input, OutputInterface $output)
    {
        $this
            ->runCommand('doctrine:schema:create', $input, $output)
            ->runCommand('assets:install', $input, $output);
    }

    /**
     * Create admin user
     */
    protected function setupBackendUser(OutputInterface $output)
    {
        $dialog      = $this->getHelperSet()->get('dialog');
        $userManager = $this->getContainer()->get('backend.user.manager');
        $username    = $dialog->ask($output, '<question>Username:</question>');
        $password    = $dialog->ask($output, '<question>Password:</question>');
        $email       = $dialog->ask($output, '<question>Email:</question>');

        $userData = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
        );
        $userManager->registerFixturesUser($userData);
    }

    /**
     * Copy logos, robots.txt from from distributions
     */
    protected function setupFiles(OutputInterface $output)
    {
        $fs           = new Filesystem();
        $web          = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
        $fs->copy($web.'/.htaccess.dist', $web.'/.htaccess');
        $fs->copy($web.'/robots.txt.dist', $web.'/robots.txt');
        $fs->copy($web.'/images/logo.png.dist', $web.'/images/logo.png');
    }

    protected function runCommand($command, InputInterface $input, OutputInterface $output)
    {
        $this
            ->getApplication()
            ->find($command)
            ->run($input, $output);

        return $this;
    }
}
