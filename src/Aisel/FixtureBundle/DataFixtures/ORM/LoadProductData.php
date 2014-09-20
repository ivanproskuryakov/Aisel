<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\DataFixtures\XMLFixtureData;
use Aisel\ProductBundle\Entity\Product;

/**
 * Product fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadProductData extends XMLFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_product.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);

            foreach ($XML->database->table as $table) {
                $product = new Product();
                $product->setLocale($table->column[1]);
                $product->setName($table->column[2]);
                $product->setSku($table->column[3]);
                $product->setPrice((float) $table->column[4]);
                $product->setQty((int) $table->column[11]);
                $product->setDescriptionShort($table->column[14]);
                $product->setDescription($table->column[15]);
                $product->setStatus((int) $table->column[16]);
                $product->setMetaUrl($table->column[18]);
                $product->setCommentStatus((int) $table->column[19]);
                $product->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $product->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $manager->persist($product);
                $manager->flush();
                $this->addReference('product_' . $table->column[0], $product);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 310;
    }
}
