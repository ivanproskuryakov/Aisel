<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\BackendUserBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * BackendUser
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_user_backend",
 *      repositoryClass="Aisel\BackendUserBundle\Document\BackendUserRepository"
 * )
 * @ODM\UniqueIndex(keys={"username"="asc", "email"="asc"})
 */
class BackendUser implements AdvancedUserInterface
{

    use IdTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $username;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @Assert\Email
     * @JMS\Type("string")
     */
    private $email;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @JMS\Exclude
     * @JMS\Type("string")
     */
    private $password;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @JMS\Exclude
     */
    private $salt;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Type("boolean")
     */
    private $enabled = false;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Type("boolean")
     */
    private $locked = true;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @JMS\Type("DateTime")
     */
    private $expiresAt;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @JMS\Type("DateTime")
     */
    private $lastLogin;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     * @JMS\Type("string")
     */
    protected $plainPassword;

    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * @return $this
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return BackendUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt
            ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set username
     *
     * @param  string      $username
     * @return BackendUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param  string      $email
     * @return BackendUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param  string      $password
     * @return BackendUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set enabled
     *
     * @param  boolean     $enabled
     * @return BackendUser
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set locked
     *
     * @param  boolean     $locked
     * @return BackendUser
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expiresAt
     *
     * @param  \DateTime   $expiresAt
     * @return BackendUser
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set lastLogin
     *
     * @param  \DateTime   $lastLogin
     * @return BackendUser
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

}
