<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\OrderBundle\Entity\Order;

/**
 * Order fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadOrderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $loremIpsumText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur dolor eget viverra commodo. Ut vehicula volutpat massa. Maecenas congue sed risus ut semper. Fusce blandit sem nunc, nec facilisis neque eleifend eget. Pellentesque fringilla velit enim, vel convallis libero ultrices vel. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas consectetur lacus et nibh facilisis, non vulputate urna convallis. Donec quis dictum magna, id dictum urna. Aliquam euismod sit amet arcu vulputate laoreet. Vivamus at leo nibh. Proin scelerisque orci sit amet sem varius, a porttitor tortor iaculis. Aenean sollicitudin diam sed euismod varius. Duis commodo a metus eu scelerisque. Etiam porttitor placerat urna vel tincidunt. Quisque congue tellus quam, non volutpat justo eleifend vehicula. Phasellus cursus convallis aliquam. Morbi adipiscing vulputate tellus, id auctor metus interdum a. Fusce diam tellus, varius commodo tincidunt in, ornare a mauris. Phasellus interdum, metus non fringilla rhoncus, odio massa pharetra orci, in semper tortor enim nec quam. Duis consectetur quis nibh at convallis. Integer tincidunt ligula sem, vitae bibendum sem elementum nec. Etiam ornare nisl lacinia, facilisis nisl a, mollis sem. Aliquam erat volutpat.';

        $rootCategory = $this->getReference('root-category');
        $childCategory = $this->getReference('child-category');

        // Nike Baseball Hat
        $hiddenOrder = new Order();
        $hiddenOrder->setName('Nike Baseball Hat');
        $hiddenOrder->setPrice(100);
        $hiddenOrder->setSku('P0001');
        $hiddenOrder->setDescriptionShort('');
        $hiddenOrder->setDescription($loremIpsumText);
        $hiddenOrder->setStatus(true);
        $hiddenOrder->setHidden(true);
        $hiddenOrder->setCommentStatus(false);
        $hiddenOrder->addCategory($rootCategory)
            ->addCategory($childCategory);

        $hiddenOrder->setMetaUrl('nike-baseball-hat');
        $hiddenOrder->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $hiddenOrder->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($hiddenOrder);
        $manager->flush();
        $this->addReference('about-order', $hiddenOrder);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
