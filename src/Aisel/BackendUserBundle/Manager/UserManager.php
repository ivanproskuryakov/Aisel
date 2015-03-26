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
use LogicException;

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

    /**
     * {@inheritDoc}
     */
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
     * Get collection
     *
     * @param array $params
     * @param string $locale
     *
     * @return array
     */
    public function getCollection($params)
    {
        $total = $this->getRepository()->getTotalFromRequest($params);
        $collection = $this->getRepository()->getCollectionFromRequest($params);
        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

    /**
     * Get single item
     *
     * @param int $id
     *
     * @return \Aisel\PageBundle\Entity\Page $pageDetails
     *
     * @throws LogicException
     */
    public function getItem($id)
    {
        $item = $this->getRepository()->find($id);

        if (!($item)) {
            throw new LogicException('Nothing found');
        }
        return array('item' => $item);
    }

    /**
     * Creates User, specially for fixtures
     *
     * @param array $userData
     *
     * @return \Aisel\BackendUserBundle\Entity\BackendUser $user
     */
    public function registerFixturesUser(array $userData)
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
     * Is backend user authenticated
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        $userToken = $this->securityContext->getToken();

        if ($userToken) {
            $user = $userToken->getUser();

            if ($user !== 'anon.') {
                $roles = $user->getRoles();

                if (in_array('ROLE_ADMIN', $roles)) return true;
            }
        }

        return false;
    }

    /**
     * Loads user by username $username
     *
     * @param array $username
     *
     * @return \Aisel\BackendUserBundle\Entity\BackendUser $user
     */
    public function loadUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(array('username' => $username));

        return $user;
    }

    /**
     * Loads user by email $email
     *
     * @param array $email
     *
     * @return \Aisel\BackendUserBundle\Entity\BackendUser $user
     */
    public function findUserByEmail($email)
    {
        $user = $this->getRepository()->findOneBy(array('email' => $email));

        return $user;
    }

    /**
     * Returns user object by combination of username and email
     *
     * @param array $username
     * @param array $email
     *
     * @return \Aisel\BackendUserBundle\Entity\BackendUser $user
     */
    public function findUser($username, $email)
    {
        $user = $this->getRepository()->findUser($username, $email);

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
