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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Generates sitemap.xml in web directory
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */

class CreateUserCommand extends ContainerAwareCommand
{

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('aisel:sitemap:generate')
            ->setHelp(<<<EOT
The <info>aisel:sitemap:generate</info> command generates sitemap with list of categories and pages:
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Index at <comment>/#!/</comment>'));

        $output->writeln(sprintf('Pages...'));
        $pages = $this->getContainer()->get('aisel.page.manager')->getEnabledPages();
        foreach ($pages as $p) {
            $url = '/#!/pages/'.$p->getMetaUrl();
            $output->writeln(sprintf('%s <comment>%s</comment>', $p->getTitle(), $url));
        }

        $output->writeln(sprintf('Categories...'));
        $categories = $this->getContainer()->get('aisel.category.manager')->getEnabledCategories();
        foreach ($categories as $c) {
            $url = '/#!/pages/'.$p->getMetaUrl();
            $output->writeln(sprintf('%s: <comment>%s</comment>', $c->getTitle(), $url));
        }

    }

}
