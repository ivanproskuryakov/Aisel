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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Process\Process;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


/**
 * InstallCommand
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
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
        $output->writeln('<info>*****************************************</info>');
        $output->writeln('<info>********** Aisel: Installation **********</info>');
        $output->writeln('<info>*****************************************</info>');
        $output->writeln('');

        $this->checkDependencies();
        $this->launchSetup($input, $output);
        $output->writeln('<info>Installation finished.</info>');
    }

    /**
     * launchSetup
     */
    protected function launchSetup(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $questionDependencies = new ConfirmationQuestion('Install frontend dependencies (Y/N)?', false);
        $questionFixtures = new ConfirmationQuestion('Create database and load fixtures (Y/N)?', false);

        if ($helper->ask($input, $output, $questionDependencies)) {
            $this->installDependencies($output);
        }

        if ($helper->ask($input, $output, $questionFixtures)) {
            $this->installDependencies($output);
        }

        return $this;
    }

    /**
     * setupDatabase
     */
    protected function setupDatabase(InputInterface $input, OutputInterface $output)
    {
        $drop = $this->getApplication()->find('doctrine:database:drop');
        $drop_args = array(
            'command' => 'doctrine:database:drop',
            '--force' => true
        );
        $drop->run(new ArrayInput($drop_args), $output);
        $this->runCommand('doctrine:database:create', $input, $output);
        $this->runCommand('doctrine:schema:create', $input, $output);
        $this->runCommand('doctrine:fixtures:load', $input, $output);
    }

    /**
     * installDependencies
     */
    protected function installDependencies(OutputInterface $output)
    {
        $commands = array(
            'sh bower.sh',
        );

        foreach ($commands as $command) {
            $process = new Process($command, null, null, null, 3600);
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });

            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }
            echo $process->getOutput();
        }
    }

    protected function runCommand($command, InputInterface $input, OutputInterface $output)
    {
        $this
            ->getApplication()
            ->find($command)
            ->run($input, $output);

        return $this;
    }

    /**
     * checkPrerequisites
     *
     * @return bool
     */
    private static function checkDependencies()
    {
        $commands = array(
            'bower'
        );

        foreach ($commands as $command) {
            if (self::commandExists($command) === false) {
                throw new LogicException("$command is required and must be installed");
            }
        }

        return true;
    }

    /**
     * @param $command
     *
     * @return bool
     */
    private static function commandExists($command)
    {
        $installedCommand = "command -v $command";

        return (bool)shell_exec($installedCommand);
    }

}
