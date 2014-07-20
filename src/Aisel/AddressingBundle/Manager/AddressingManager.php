<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aisel\AdminBundle\Utility\UrlUtility;

/**
 * Manager for Addressings, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AddressingManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }


    /**
     * Get single detailed addressing by Id
     *
     * @param  int $id
     *
     * @return \Aisel\AddressingBundle\Entity\Addressing $addressingDetails
     *
     * @throws NotFoundHttpException*
     */
    public function getAddressing($id)
    {
        $addressing = $this->em->getRepository('AiselAddressingBundle:Addressing')->find($id);

        if (!($addressing)) {
            throw new NotFoundHttpException('Nothing found');
        }

        return $addressing;
    }


}
