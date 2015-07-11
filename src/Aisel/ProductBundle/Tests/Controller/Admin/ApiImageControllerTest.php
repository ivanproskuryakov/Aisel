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

        $this->getFixtureFiles();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Filename on hard disk.
     */
    private $filenames;

    private function getFixtureFiles()
    {
        $fixturesDir = static::$kernel
                ->getContainer()
                ->getParameter('kernel.root_dir') . '/../src/Aisel/ProductBundle/Tests/fixtures/';

        array(
            'basePath' => '',
            'files' => '',
        );
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

            $response = $this->client->getResponse();
            $content = $response->getContent();

            // Create Product Image entity
            if ($response->getStatusCode() === 201) {
                $filename = json_decode($content, true);
                $data = [
                    'filename' => $filename,
                    'title' => 'title',
                    'description' => 'description',
                    'product' => [
                        'id' => $product->getId()
                    ]
                ];

                $this->client->request(
                    'POST',
                    '/'. $this->api['backend'] .
                    '/media/image/',
                    [],
                    [],
                    ['CONTENT_TYPE' => 'application/json'],
                    json_encode($data)
                );

                $response = $this->client->getResponse();
                $content = $response->getContent();
                $statusCode = $response->getStatusCode();
                $this->assertEquals($statusCode, 201);
                $this->assertEquals($content, '');
            }

        }

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));
    }

    public function testPutProductImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'title' => 'title',
            'description' => 'description'
        ];

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));

        foreach ($product->getImages() as $image) {
            $this->client->request(
                'PUT',
                '/'. $this->api['backend'] .
                '/media/image/'. $image->getId(),
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );

            $response = $this->client->getResponse();
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();
            $result = json_decode($content, true);
            $this->assertEquals($statusCode, 204);
            $this->assertEquals($result, '');
        }

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        foreach ($product->getImages() as $image) {
            $this->assertEquals($data['title'], $image->getTitle());
            $this->assertEquals($data['description'], $image->getDescription());
        }

    }

    public function testGetProductImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));

        foreach ($product->getImages() as $image) {
            $this->client->request(
                'GET',
                '/'. $this->api['backend'] .
                '/media/image/'. $image->getId(),
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );

            $response = $this->client->getResponse();
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();
            $result = json_decode($content, true);

            $this->assertEquals($statusCode, 200);
            $this->assertNotNull($result['id'], $product->getId());
            $this->assertNotNull($result['filename']);
            $this->assertNotNull($result['title']);
            $this->assertNotNull($result['description']);
            $this->assertNotNull($result['description']);
            $this->assertNotNull($result['main_image']);
            $this->assertNotNull($result['updated_at']);
            $this->assertNotNull($result['updated_at']);
        }
    }

    public function testDeleteProductImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));

        foreach ($product->getImages() as $image) {
            $this->client->request(
                'DELETE',
                '/'. $this->api['backend'] .
                '/media/image/'. $image->getId(),
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );
        }

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(0, count($product->getImages()->toArray()) );
    }

}
