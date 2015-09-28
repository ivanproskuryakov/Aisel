<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
