<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SitemapBundle\Tests\Controller;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Symfony\Component\Process\Process;

/**
 * ApiControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiControllerTest extends AbstractWebTestCase
{

    /**
     * @var string
     */
    private $file;

    public function setUp()
    {
        parent::setUp();

        $directory = realpath(
            $this
                ->getContainer()
                ->get('kernel')
                ->getRootDir() . '/../frontend/web/'
        );
        $this->file = $directory . '/sitemap.xml';
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testSitemapAction()
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }

        $products = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findBy([
                'status' => true,
            ]);
        $pages = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findBy([
                'status' => true,
            ]);
        $totalText = sprintf('URL total: %d', count($products) + count($pages));
        $command = 'bin/console aisel:sitemap:generate';
        $process = new Process($command, null, null, null, 3600);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->assertNotNull(strpos($process->getOutput(), $totalText));
        $this->assertFileExists($this->file);
    }

}
