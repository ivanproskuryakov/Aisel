<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\ORM\Local;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\ProductBundle\Entity\Product;
use Aisel\ProductBundle\Entity\Image;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Product fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadProductData extends XMLFixture implements OrderedFixtureInterface
{

    protected $productImage = '500x500.jpg';
    protected $fixturesName = array(
        'en/aisel_product.xml',
        'ru/aisel_product.xml',
        'es/aisel_product.xml',
    );

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
                    $product = new Product();
                    $product->setLocale($table->column[1]);
                    $product->setName($table->column[2]);
                    $product->setSku($table->column[3]);
                    $product->setPrice((float) $table->column[4]);
                    $product->setQty((int) $table->column[11]);
                    $product->setDescriptionShort($table->column[14]);
                    $product->setDescription($table->column[15]);
                    $product->setStatus((int) $table->column[16]);
                    $product->setHidden((int) $table->column[17]);
                    $product->setCommentStatus((int) $table->column[18]);
                    $product->setMetaUrl($table->column[19]);

                    $categories = explode(",", $table->column[20]);
                    foreach ($categories as $c) {
                        $category = $this->getReference('product_category_' . $c);
                        $product->addCategory($category);
                    }

                    $manager->persist($product);
                    $manager->flush();
                    $this->addReference('product_' . $table->column[0], $product);
                    $this->setProductImage($manager, $product);
                }
            }
        }
    }

    private function setProductImage(ObjectManager $manager, $product)
    {

        $uploadDir = $this->container->getParameter('application.media.product.upload_dir');
        $fixtureImage = dirname($this->container->getParameter('kernel.root_dir')) .
            $this->container->getParameter('aisel_fixture.xml.path') .
            DIRECTORY_SEPARATOR . 'images/products/' . $this->productImage;
        $productDir = $uploadDir . DIRECTORY_SEPARATOR . $product->getId();

        $fs = new Filesystem();
        if (!$fs->exists($uploadDir)) {
            try {
                $fs->mkdir($uploadDir);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at " . $e->getPath();
            }
        }
        $fileName = '/' . $product->getId() . '/' . $this->productImage;

        if (file_exists($fixtureImage)) {

            if (file_exists($productDir) === false ) {
                mkdir($productDir);
            }
            $newPath = realpath($productDir) . DIRECTORY_SEPARATOR . $this->productImage;

            if (file_exists($newPath)) {
                unlink($newPath);
            }
            copy($fixtureImage, $newPath);

            $image = new Image();
            $image->setFilename($fileName);
            $image->setProduct($product);
            $image->setMainImage(true);
            $manager->persist($image);
            $manager->flush();
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
