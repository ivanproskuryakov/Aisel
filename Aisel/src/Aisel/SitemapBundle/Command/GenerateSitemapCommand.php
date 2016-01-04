<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SitemapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates sitemap.xml in web directory
 * Command: "aisel:sitemap:generate"
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class GenerateSitemapCommand extends ContainerAwareCommand
{

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('aisel:sitemap:generate')
            ->setHelp(<<<EOT
The <info>aisel:sitemap:generate</info> command generates sitemap with list of nodes and pages.
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Sitemap generator started ...'));

        $directory = realpath(
            $this
                ->getContainer()
                ->get('kernel')
                ->getRootDir() . '/../frontend/web/'
        );
        $file = $directory . '/sitemap.xml';

        $total = $this
            ->getContainer()
            ->get('aisel.sitemap.manager')
            ->buildSitemap($file);

        $output->writeln(sprintf('URL total: %s', $total));
        $output->writeln(sprintf('File sitemap.xml generated!'));
    }

}
