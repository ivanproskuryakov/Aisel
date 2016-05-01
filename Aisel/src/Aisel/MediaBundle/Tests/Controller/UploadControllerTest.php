<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\MediaBundle\Tests\Controller;

use Aisel\MediaBundle\Entity\Media;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ApiImageControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UploadControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->getFixtureFiles();
        $this->logInBackend();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @var array Filenames
     */
    protected $filenames;

    private function getFixtureFiles()
    {
        $fixturesDir = static::$kernel
                ->getContainer()
                ->getParameter('kernel.root_dir') . '/../src/Aisel/MediaBundle/Tests/fixtures/';

        array(
            'basePath' => '',
            'files' => '',
        );
        $this->filenames['basePath'] = $fixturesDir;
        $this->filenames['files'][] = 'logo_magazento.png';
        $this->filenames['files'][] = 'IMG_0738.jpg';
        $this->filenames['files'][] = 'Rising-1.jpeg';
    }

    public function upload($file)
    {
        $filePath = realpath($this->filenames['basePath'] . $file);
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
                '/' . $this->api['backend'] . '/media/upload/image/',
                $data,
                [],
                ['CONTENT_TYPE' => 'application/json']
            );

            $this->client->request(
                'POST',
                '/' . $this->api['backend'] . '/media/upload/image/',
                $data,
                ['file' => $fileUpload],
                ['CONTENT_TYPE' => 'application/json']
            );
        }

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals($statusCode, 201);
        $this->assertNotNull($result);

        $image = $this
            ->em
            ->getRepository('Aisel\MediaBundle\Entity\Media')
            ->findOneBy(['id' => $result['id']]);

        $filePath = realpath($this->filenames['basePath'] . $file);
        $binary = file_get_contents($filePath);
        $binaryLength = strlen($binary);

        $uploadedFile = realpath(
            static::$kernel->getContainer()->getParameter('assetic.write_to') .
            $image->getFilename()
        );
        $uploadedBinary = file_get_contents($uploadedFile);
        $uploadedBinaryLength = strlen($uploadedBinary);

        $this->assertEquals($image->getType(), Media::MEDIA_IMAGE);
        $this->assertEquals($uploadedBinaryLength, $binaryLength);

        return $result;
    }

    public function testUploadImageAction()
    {
        $filename = $this->upload($this->filenames['files'][0]);
        $this->assertNotNull($filename);
    }

}
