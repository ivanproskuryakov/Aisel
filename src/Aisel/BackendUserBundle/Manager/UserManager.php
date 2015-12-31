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
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * UserManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserManager implements UserProviderInterface
{
    /**
     * @var EncoderFactory
     */
    protected $encoder;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param EncoderFactory $encoder
     * @param SecurityContext $securityContext
     */
    public function __construct(
        EntityManager $entityManager,
        EncoderFactory $encoder,
        SecurityContext $securityContext
    )
    {
        $this->em = $entityManager;
        $this->encoder = $encoder;
        $this->securityContext = $securityContext;
    }

    /**
     * Creates User, specially for fixtures
     *
     * @param array $userData
     *
     * @return BackendUser $user
     */
    public function registerFixturesUser(array $userData)
    {
        $user = new BackendUser();
        $user->setEmail($userData['email']);
        $user->setPlainPassword($userData['password']);
        $user->setEnabled(true);
        $user->setLocked(false);
        $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Is user password correct
     *
     * @param BackendUser $user
     * @param string $password
     *
     * @return boolean $isValid
     */
    public function checkUserPassword(BackendUser $user, $password)
    {
        $encoder = $this->encoder->getEncoder($user);

        if (!$encoder) {
            return false;
        }
        $isValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        return $isValid;
    }

    /**
     * authenticatedUser
     *
     * @return BackendUser|boolean
     */
    public function getAuthenticatedUser()
    {
        $userToken = $this->securityContext->getToken();

        if ($userToken) {
            $user = $userToken->getUser();

            if ($user !== 'anon.') {
                $roles = $user->getRoles();

                if (in_array('ROLE_ADMIN', $roles)) {
                    return $user;
                }
            }
        }
    }

    /**
     * loadUserByEmail
     *
     * @param array $email
     * @return BackendUser $user
     */
    public function loadUserByEmail($email)
    {
        $user = $this->loadUserByUsername($email);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($email)
    {
        $user = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(array('email' => $email));

        return $user;
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }

}
