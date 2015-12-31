<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\Manager;

use Doctrine\ORM\EntityManager;
use Swift_Mailer;
use Symfony\Component\Templating\EngineInterface;

/**
 * ContactManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ContactManager
{

    const MAIL_CONTACT_FORM = 'Contact Form';

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $appEmail;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @param EntityManager $dm
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param $appEmail
     */
    public function __construct(
        EntityManager $dm,
        Swift_Mailer $mailer,
        EngineInterface $templating,
        $appEmail
    )
    {
        $this->dm = $dm;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->appEmail = $appEmail;
    }

    /**
     * Get Templating service
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * Get Mailer service
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Send email to administration E-mail
     * @param  array $params
     * @return array
     */
    public function sendMail($params)
    {

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject($this::MAIL_CONTACT_FORM)
                ->setFrom($params['email'])
                ->setTo($this->appEmail)
                ->setCc($params['email'])
                ->setBody(
                    $this->getTemplating()->render(
                        'AiselContactBundle:Default:email.txt.twig',
                        array(
                            'name' => $params['name'],
                            'email' => $params['email'],
                            'phone' => $params['phone'],
                            'message' => $params['message']
                        )
                    )
                );

            $response = $this->getMailer()->send($message);
        } catch (\Swift_TransportException $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

}
