<?php
namespace Aisel\UserBundle\Manager;

use Aisel\UserBundle\Entity\FrontendUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserManager  implements UserProviderInterface
{
    protected $encoder;
    protected $em;

    public function __construct($em, $encoder)
    {
        $this->encoder = $encoder;
        $this->em = $em;

    }

    protected function getRepository() {
        return $this->em->getRepository('AiselUserBundle:FrontendUser');
    }

    public function checkUserPassword(FrontendUser $user, $password)
    {
        $encoder = $this->encoder->getEncoder($user);

        if(!$encoder){
            return false;
        }
        $isValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

//        var_dump();
//        var_dump($user);
//        var_dump($encoder);
//        exit();

        return $isValid;
    }


    public function registerUser(Array $userData)
    {
        $user = $this->loadUserByUsername($userData['username']);

        if (!$user) {
            $user = new FrontendUser();
            $encoder = $this->encoder->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($userData['password'], $user->getSalt());

            $user->setEmail($userData['email']);
            $user->setUsername($userData['username']);
            $user->setPassword($encodedPassword);
            $user->setIsActive(true);
            $user->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $user->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

            $this->em->persist($user);
            $this->em->flush();
            return $user;

        } else {
            return false;
        }

    }


    public function loadUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(array('username' => $username));
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
