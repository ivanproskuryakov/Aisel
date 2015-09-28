<?php

namespace Aisel\ResourceBundle\Composer;

use Symfony\Component\Process\Process;

/**
 * Installer
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class Installer
{
    /**
     * setupFiles
     */
    public static function setupFiles()
    {
        $command = 'php app/console aisel:install:files';

        $process = new Process($command, null, null, null, 3600);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
        echo $process->getOutput();
    }

}
