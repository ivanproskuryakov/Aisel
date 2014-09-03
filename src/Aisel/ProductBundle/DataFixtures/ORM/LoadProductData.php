<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\ResourceBundle\DataFixtures\ORM\AbstractFixtureData;
use Aisel\ProductBundle\Entity\Product;

/**
 * Product fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadProductData extends AbstractFixtureData implements OrderedFixtureInterface
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
                $product->setName($table->column[1]);
                $product->setSku($table->column[2]);
                $product->setPrice((float) $table->column[3]);
                $product->setQty((int) $table->column[10]);
                $product->setDescriptionShort($table->column[13]);
                $product->setDescription($table->column[14]);
                $product->setStatus((int) $table->column[15]);
                $product->setMetaUrl($table->column[17]);
                $product->setCommentStatus((int) $table->column[18]);
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
