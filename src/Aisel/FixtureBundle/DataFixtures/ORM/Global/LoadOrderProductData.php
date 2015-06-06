<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\Model\XMLFixture;

/**
 * Order fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadOrderProductData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_order_from_product.xml');

    /**
     * Order manager
     * @return \Aisel\OrderBundle\Manager\OrderManager
     */
    protected function getOrderManager()
    {
        return $this->container->get('aisel.order.manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);

                foreach ($XML->database->table as $table) {
                    $locale = $table->column[1];
                    $orderInfo = array(
                        'payment_method' => (string) $table->column[2],
                        'billing_country' => (string) $table->column[5],
                        'billing_region' => (string) $table->column[6],
                        'billing_city' => (string) $table->column[7],
                        'billing_phone' => (string) $table->column[8],
                        'billing_comment' => (string) $table->column[9],
                        'locale' => (string) $locale,
                    );
                    $frontendUser = $this->getReference('frontenduser_' . $table->column[3]);
                    $productIds = explode(",", (string) $table->column[4]);
                    $products = array();

                    foreach ($productIds as $id) {
                        $products[] = $this->getReference('product_' . $id);
                    }
                    $order = $this
                        ->getOrderManager()
                        ->createOrderFromProducts(
                            $frontendUser,
                            $products,
                            $orderInfo
                        );
                    $this->addReference('order_' . $table->column[0], $order);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 420;
    }
}
