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
 * @author Ivan Proskoryakov <volgodark@gmail.com>
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
The <info>aisel:sitemap:generate</info> command generates sitemap with list of categories and pages.
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Sitemap generator started ...'));
        $urls = array();

        // Pages
        $pages = $this->getContainer()->get('aisel.page.manager')->getEnabledPages();
        foreach ($pages as $p) {
            $urls[] = '/' . $p->getLocale() . '/page/' . $p->getMetaUrl() . '/';
        }
        // Products
        $pages = $this->getContainer()->get('aisel.product.manager')->getEnabledProducts();
        foreach ($pages as $p) {
            $urls[] = '/' . $p->getLocale() . '/product/' . $p->getMetaUrl() . '/';
        }

        $sitemapContents = $this->getContainer()->get('templating')->render(
            'AiselSitemapBundle:Default:sitemap.txt.twig',
            array('urls' => $urls)
        );
        $webFolder = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web/');
        $sitemapFile = $webFolder . '/sitemap.xml';
        file_put_contents($sitemapFile, $sitemapContents);
        $output->writeln(sprintf('URL total: %s', count($urls)));
        $output->writeln(sprintf('File sitemap.xml generated!'));
    }

}
