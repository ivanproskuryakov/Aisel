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
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        foreach ($product->getImages() as $image) {
            $this->em->remove($image);
            $this->em->flush();
        }

        foreach ($this->filenames['files'] as $file) {
            $filename = $this->upload($product->getId(), $file);

            // Create Product Image entity
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
                '/' . $this->api['backend'] .
                '/media/image/',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );

            $response = $this->client->getResponse();
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();
            $result = json_decode($content, true);
            $parts = explode('/', $response->headers->get('location'));
            $id = array_pop($parts);
            $this->assertEquals($statusCode, 201);
            $this->assertEquals($result, '');
            $this->assertNotNull($id);
        }

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));
    }

    public function testPutImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));

        $filename = $this->upload($product->getId(), $this->filenames['files'][0]);

        $data = [
            'title' => 'title',
            'description' => 'description',
            'filename' => $filename
        ];

        $image = $product->getImages()[0];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] .
            '/media/image/' . $image->getId(),
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

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        foreach ($product->getImages() as $image) {
            $this->assertEquals($data['title'], $image->getTitle());
            $this->assertEquals($data['description'], $image->getDescription());
        }

    }

    public function testGetImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));

        foreach ($product->getImages() as $image) {
            $this->client->request(
                'GET',
                '/' . $this->api['backend'] .
                '/media/image/' . $image->getId(),
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
            $this->assertNotNull($result['main_image']);
            $this->assertNotNull($result['updated_at']);
            $this->assertNotNull($result['updated_at']);
        }
    }

    public function testDeleteImageAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(count($this->filenames['files']), count($product->getImages()));

        foreach ($product->getImages() as $image) {
            $this->client->request(
                'DELETE',
                '/' . $this->api['backend'] .
                '/media/image/' . $image->getId(),
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );
        }

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->assertEquals(0, count($product->getImages()->toArray()));
    }

}
