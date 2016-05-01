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

use Aisel\FixtureBundle\Model\XMLFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Cart fixtures
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadCartData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_cart.xml');

    /**
     * Cart manager
     * @return \Aisel\CartBundle\Manager\CartManager
     */
    protected function getCartManager()
    {
        return $this->container->get('aisel.cart.manager');
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
                    $user = $this->getReference('user_' . $table->column[1]);
                    $product = $this->getReference('product_' . $table->column[3]);
                    $cartItem = $this->getCartManager()->addProductToCart(
                        $user,
                        $product->getId(),
                        (int) $table->column[2]
                    );
                    $this->addReference('cart_' . $table->column[0], $cartItem);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 400;
    }
}
