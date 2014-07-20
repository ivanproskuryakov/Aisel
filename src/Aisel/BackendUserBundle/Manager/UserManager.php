<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\BackendUserBundle\Manager;

use Aisel\BackendUserBundle\Entity\BackendUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * Manager for backend users. Register, Load and others ...
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class UserManager implements UserProviderInterface
{
    protected $encoder;
    protected $em;
    protected $securityContext;

    public function __construct($em, $encoder, $securityContext)
    {
        $this->encoder = $encoder;
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    protected function getRepository()
    {
        return $this->em->getRepository('AiselBackendUserBundle:BackendUser');
    }

    /**
     * Create User, specially for fixtures
     */
    public function registerFixturesUser(Array $userData)
    {
        $user = new BackendUser();
        $encoder = $this->encoder->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($userData['password'], $user->getSalt());

        $user->setEmail($userData['email']);
        $user->setUsername($userData['username']);
        $user->setPassword($encodedPassword);
        $user->setEnabled(true);
        $user->setLocked(false);

        $user->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $user->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(array('username' => $username));

        return $user;
    }

    public function findUserByEmail($email)
    {
        $user = $this->getRepository()->findOneBy(array('email' => $email));

        return $user;
    }

    public function findUser($username, $email)
    {
        $user = $this->em->getRepository('AiselBackendUserBundle:BackendUser')->findUser($username, $email);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }

}
