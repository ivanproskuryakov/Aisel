<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\MongoDB\Local;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\ProductBundle\Entity\Product;
use Aisel\MediaBundle\Entity\Media;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Product fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadProductData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/aisel_product.xml',
    );

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Delete all files and directories
        $this->cleanMediaDir();

        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);

                foreach ($XML->database->table as $table) {

                    $product = new Product();
                    $product->setLocale($table->column[1]);
                    $product->setName($table->column[2]);
                    $product->setSku($table->column[3]);
                    $product->setPrice((int)$table->column[4]);
                    $product->setQty((int)$table->column[11]);
                    $product->setDescriptionShort($table->column[14]);
                    $product->setDescription($table->column[15]);
                    $product->setStatus((int)$table->column[16]);
                    $product->setHidden((int)$table->column[17]);
                    $product->setCommentStatus((int)$table->column[18]);
                    $product->setMetaUrl($table->column[19]);

                    $nodes = explode(",", $table->column[20]);

                    foreach ($nodes as $c) {
                        $node = $this->getReference('product_node_' . $c);
                        $product->addNode($node);
                    }

//                    $review = explode(",", $table->column[21]);
//
//                    foreach ($review as $r) {
//                        $review = $this->getReference('prowduct_review_' . $r);
//                        $product->addReview($review);
//                    }

                    $manager->persist($product);
                    $manager->flush();

                    $this->addReference('product_' . $table->column[0], $product);
                    $images = $this->setProductImage($manager, $product);

                    $product->setMedias($images);
                    $manager->persist($product);
                    $manager->flush();
                }
            }
        }
    }

    private function cleanMediaDir()
    {
        $uploadDir = realpath($this->container->getParameter('application.media.upload_path'));
        $fs = new Filesystem();
        $fs->remove($uploadDir);
        $fs->mkdir($uploadDir);
    }

    /**
     * @param string $dir
     */
    private function createDirIfNotExists($dir)
    {
        $fs = new Filesystem();
        if (!$fs->exists($dir)) {
            try {
                $fs->mkdir($dir);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at " . $e->getPath();
            }
        }
    }

    /**
     * @return string $dir
     */
    private function getRandomProductDirectory()
    {
        $productDirectories = [];

        $fixtureDirectory = dirname($this->container->getParameter('kernel.root_dir')) .
            $this->container->getParameter('aisel_fixture.xml.path') .
            DIRECTORY_SEPARATOR . 'images/products/';

        $finder = new Finder();

        foreach ($finder->directories()->in($fixtureDirectory) as $dir) {
            /** @var SplFileInfo $dir */
            $productDirectories[] = $dir->getPathname();
        }

        $dir = $productDirectories[array_rand($productDirectories, 1)];

        return $dir;
    }

    private function setProductImage(ObjectManager $manager, $product)
    {
        $images = new ArrayCollection();

        $finder = new Finder();
        $productImages = $finder
            ->files()
            ->in($this->getRandomProductDirectory());

        foreach ($productImages as $productImage) {
            /** @var Media $image */
            $image = $this
                ->container
                ->get('aisel.media.manager')
                ->createMediaFromFile($productImage->getPathname(), 'image', false);

            $images->add($image);
        }
        $image->setMainImage(true);
        $manager->persist($image);
        $manager->flush();

        return $images;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 340;
    }
}
