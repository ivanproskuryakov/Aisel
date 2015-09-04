<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SitemapBundle\Manager;

use LogicException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Templating\EngineInterface;

/**
 * SitemapManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class SitemapManager
{

    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * Constructor
     *
     * @param DocumentManager $dm
     * @param EngineInterface $templating
     */
    public function __construct(DocumentManager $dm, $templating)
    {
        $this->templating = $templating;
        $this->dm = $dm;
    }

    /**
     * buildSitemap
     *
     * @param string $file
     * @return int $total
     */
    public function buildSitemap($file)
    {
        // Products
        $products = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findBy([
                'status' => true,
            ]);

        foreach ($products as $p) {
            $urls[] = '/' . $p->getLocale() . '/product/view/' . $p->getMetaUrl() . '/';
        }

        // Pages
        $pages = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->findBy([
                'status' => true,
            ]);

        foreach ($pages as $p) {
            $urls[] = '/' . $p->getLocale() . '/page/view/' . $p->getMetaUrl() . '/';
        }

        $contents = $this
            ->templating
            ->render(
                'AiselSitemapBundle:Default:sitemap.txt.twig',
                array('urls' => $urls)
            );
        file_put_contents($file, $contents);
        $total = count($urls);

        return $total;
    }

}
