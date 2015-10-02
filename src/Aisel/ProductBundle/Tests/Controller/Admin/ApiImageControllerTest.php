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

use Aisel\MediaBundle\Tests\Controller\UploadControllerTest;

/**
 * ApiImageControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiImageControllerTest extends UploadControllerTest
{

    public function testPostImageAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);

        foreach ($product->getMedias() as $image) {
            $product->removeMedia($image);
        }

        $this->assertEquals(0, count($product->getMedias()));

        foreach ($this->filenames['files'] as $file) {
            $image = $this->upload($file);
            $this->assertNotNull($image['id']);
            $images[] = ['id' => $image['id']];
        }

        // Patching product
        $data = [
            'images' => $images,
        ];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/product/' . $product->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertEmpty($content);
        $this->assertTrue(204 === $statusCode);
        $this->dm->clear();

        //Checking
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->find($product->getId());


        $this->assertEquals(count($this->filenames['files']), count($product->getMedias()));
    }

    public function testPutImageAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);

        $image = $product->getMedias()[0];
        $data = [
            'title' => time(),
            'description' => time(),
        ];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] .
            '/media/' . $image->getId(),
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

        $this->dm->clear();

        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);
        $image = $product->getMedias()[0];

        $this->assertEquals($image->getTitle(), $data['title']);
        $this->assertEquals($image->getDescription(), $data['description']);
    }

    public function testGetImageAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getMedias()));

        foreach ($product->getMedias() as $image) {
            $this->client->request(
                'GET',
                '/' . $this->api['backend'] .
                '/media/' . $image->getId(),
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );

            $response = $this->client->getResponse();
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();
            $result = json_decode($content, true);

            $this->assertEquals($statusCode, 200);
            $this->assertNotNull($result['filename']);
            $this->assertNotNull($result['main_image']);
            $this->assertNotNull($result['updated_at']);
            $this->assertNotNull($result['updated_at']);
        }
    }

    public function testDeleteImageAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getMedias()));

        foreach ($product->getMedias() as $image) {
            $this->client->request(
                'DELETE',
                '/' . $this->api['backend'] .
                '/media/' . $image->getId(),
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );

            $response = $this->client->getResponse();
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();

            $this->assertEquals($statusCode, 204);
            $this->assertEmpty($content);
        }

        $data['medias'] = [];
        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/product/' . $product->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->dm->clear();

        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(0, count($product->getMedias()->toArray()));
    }

}
