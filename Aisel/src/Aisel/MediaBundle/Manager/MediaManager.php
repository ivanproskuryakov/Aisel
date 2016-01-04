<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\MediaBundle\Manager;

use Aisel\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * MediaManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class MediaManager
{

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * @var string
     */
    protected $uploadPath;

    /**
     * @var string
     */
    protected $mediaPath;

    /**
     * Constructor
     *
     * @param EntityManager $dm
     * @param string $uploadPath
     * @param string $mediaPath
     */
    public function __construct(EntityManager $dm, $uploadPath, $mediaPath)
    {
        $this->dm = $dm;
        $this->uploadPath = $uploadPath;
        $this->mediaPath = $mediaPath;
    }

    /**
     * createMediaFromFile
     *
     * @param string $pathOld
     * @param string $type
     * @param boolean $move
     *
     * @return Media $media
     */
    public function createMediaFromFile($pathOld, $type, $move = true)
    {
        $media = new Media();
        $media->setType($type);
        $media->setMainImage(false);
        $this->dm->persist($media);
        $this->dm->flush();

        $newName = $media->getId() . '.' . pathinfo($pathOld, PATHINFO_EXTENSION);
        $fileDir = realpath($this->uploadPath) .
            '/' . date("Y") .
            '/' . date("m") .
            '/' . date("d");
        $pathNew = $fileDir . '/' . $newName;

        $pathWeb = $this->mediaPath .
            '/' . date("Y") .
            '/' . date("m") .
            '/' . date("d") .
            '/' . $newName;

        $fs = new Filesystem();
        $fs->mkdir($fileDir);

        if ($move) {
            $fs->rename($pathOld, $pathNew);
        } else {
            $fs->copy($pathOld, $pathNew);
        }

        //Update document
        $media->setFilename($pathWeb);
        $this->dm->persist($media);
        $this->dm->flush();

        return $media;
    }
}
