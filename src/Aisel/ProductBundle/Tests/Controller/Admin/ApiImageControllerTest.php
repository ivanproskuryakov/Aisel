<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Controller\Admin;

use Aisel\ResourceBundle\Tests\AbstractBackendWebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * ApiImageControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiImageControllerTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Filename on hard disk.
     */
    private $filenames = array(
        'basePath' => '',
        'files' => '',
    );

    private function getFixtureFiles()
    {
        $fixturesDir = static::$kernel
                ->getContainer()
                ->getParameter('kernel.root_dir') . '/../src/Aisel/ProductBundle/Tests/fixtures/';

        $this->filenames['basePath'] = $fixturesDir;
        $this->filenames['files'][] = 'logo_magazento.png';
        $this->filenames['files'][] = 'IMG_0738.jpg';
        $this->filenames['files'][] = 'Rising-1.jpeg';
    }

    public function testUploadProductImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        foreach ($product->getImages() as $image) {
            $this->em->remove($image);
            $this->em->flush();
        }

        $uploadDir = realpath(sprintf(
            "%s/%s",
            $this->getContainer()->getParameter('application.media.product.upload_dir'),
            $product->getId()
        ));
        $this->getFixtureFiles();

        foreach ($this->filenames['files'] as $file) {
            $filePath = realpath($this->filenames['basePath'].$file);
            $binary = file_get_contents($filePath);
            $binaryLength = strlen($binary);

            $chunkLength = 1024 * 1024;
            $chunks = str_split($binary, $chunkLength);
            $mimeType = mime_content_type($filePath);

            foreach ($chunks as $chunkIndex => $chunk) {
                $chunkSize = strlen($chunk);
                $tempFileName = tempnam('/tmp/', 'file-');
                file_put_contents($tempFileName, $chunk);
                $fileUpload = new UploadedFile(
                    $tempFileName,
                    $file,
                    $mimeType
                );

                $data = array(
                    'flowChunkNumber' => $chunkIndex + 1,
                    'flowChunkSize' => $chunkLength,
                    'flowCurrentChunkSize' => $chunkSize,
                    'flowTotalSize' => $binaryLength,
                    'flowIdentifier' => $binaryLength . $file,
                    'flowFilename' => $file,
                    'flowRelativePath' => $file,
                    'flowTotalChunks' => count($chunks),
                );

                $this->client->request(
                    'GET',
                    '/'. $this->api['backend'] . '/product/'.$product->getId().'/image/upload/',
                    $data,
                    [],
                    ['CONTENT_TYPE' => 'application/json']
                );

                $this->client->request(
                    'POST',
                    '/'. $this->api['backend'] . '/product/'.$product->getId().'/image/upload/',
                    $data,
                    ['file' => $fileUpload],
                    ['CONTENT_TYPE' => 'application/json']
                );
            }

            $uploadedFile = $uploadDir.'/'.$file;
            $uploadedBinary = file_get_contents($uploadedFile);
            $uploadedBinaryLength = strlen($uploadedBinary);

            $this->assertEquals($uploadedBinaryLength, $binaryLength);
            $this->assertFileExists($uploadedFile);
        }

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));
    }

    public function testCheckProductImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/' . $product->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $product->getId());
        $this->assertTrue(is_array($result['images']));
    }


}
