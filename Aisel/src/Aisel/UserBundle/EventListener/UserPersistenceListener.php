<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\EventListener;

use Aisel\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class UserPersistenceListener
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserPersistenceListener
{

    /**
     * @var EncoderFactory
     */
    protected $encoder;

    /**
     * Constructor
     * @param EncoderFactory $encoder
     */
    public function __construct(EncoderFactory $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifeCycleEventArgs $args)
    {
        $this->setPassword($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifeCycleEventArgs $args)
    {
        $this->setPassword($args);
        $this->setRole($args);
    }

    /**
     * setPassword
     *
     * @param LifecycleEventArgs $args
     */
    public function setPassword(LifeCycleEventArgs $args)
    {
        /** @var User $object */
        $object = $args->getEntity();

        if ($object instanceof AdvancedUserInterface) {

            $salt = md5(uniqid(null, true));
            $object->setSalt($salt);

            $encoder = $this->encoder->getEncoder($object);
            $encodedPassword = $encoder->encodePassword(
                $object->getPlainPassword(),
                $object->getSalt()
            );

            $object->setPassword($encodedPassword);
            $object->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

    /**
     * setRole
     *
     * @param LifecycleEventArgs $args
     */
    public function setRole(LifeCycleEventArgs $args)
    {
        /** @var User $object */
        $object = $args->getEntity();

        if ($object instanceof AdvancedUserInterface) {
            $object->setRoles(User::ROLE_USER);
        }
    }


}
