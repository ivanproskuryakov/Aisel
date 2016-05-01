<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\Manager;

use Aisel\UserBundle\Entity\User;
use Swift_Mailer;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * UserMailManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserMailManager
{

    const MAIL_ACCOUNT_NEW = 'New Account';
    const MAIL_ACCOUNT_TERMINATE = 'Account Terminated';
    const MAIL_PASSWORD_NEW = 'New Password';

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $websiteEmail;

    /**
     * Constructor
     *
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param string $websiteEmail
     */
    public function __construct(
        Swift_Mailer $mailer,
        EngineInterface $templating,
        $websiteEmail
    )
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->websiteEmail = $websiteEmail;
    }

    /**
     * sendRegisterUserMail
     *
     * @param User $user
     * @param string $password
     * @return mixed
     */
    public function sendRegisterUserMail(User $user, $password)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this::MAIL_ACCOUNT_NEW)
            ->setFrom($this->websiteEmail)
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'AiselUserBundle:Email:registration.txt.twig',
                    array(
                        'password' => $password,
                        'email' => $user->getEmail(),
                    )
                )
            );

        $this->mailer->send($message);
    }

    /**
     * sendNewPasswordEmail
     *
     * @param User $user
     * @param string $password
     * @return mixed
     */
    public function sendNewPasswordEmail(User $user, $password)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this::MAIL_PASSWORD_NEW)
            ->setFrom($this->websiteEmail)
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'AiselUserBundle:Email:newPassword.txt.twig',
                    array(
                        'email' => $user->getEmail(),
                        'password' => $password,
                    )
                )
            );
        $this->mailer->send($message);
    }

    /**
     * sendAccountTerminateEmail
     *
     * @param User $user
     * @return mixed
     */
    public function sendAccountTerminateEmail(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this::MAIL_ACCOUNT_TERMINATE)
            ->setFrom($this->websiteEmail)
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'AiselUserBundle:Email:accountTerminate.txt.twig',
                    array(
                        'email' => $user->getEmail(),
                    )
                )
            );
        $this->mailer->send($message);
    }
}
