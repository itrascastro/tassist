<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"username"}, message="Username already taken")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="forename", type="string", length=255, unique=false)
     * @Assert\NotBlank(message="Name cannot be empty")
     */
    private $forename;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, unique=false)
     * @Assert\NotBlank(message="Surname cannot be empty")
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * This field will not be persisted
     * It is used to store the password in the form
     *
     * @Assert\NotBlank(message="Password cannot be empty")
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
     *      message="Password Error: Use 1 upper case letter, 1 lower case letter, and 1 number"
     * )
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank(message="Username cannot be empty")
     */
    private $username;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mondayIn", type="time")
     */
    private $mondayIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mondayOut", type="time")
     */
    private $mondayOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tuesdayIn", type="time")
     */
    private $tuesdayIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tuesdayOut", type="time")
     */
    private $tuesdayOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="wednesdayIn", type="time")
     */
    private $wednesdayIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="wednesdayOut", type="time")
     */
    private $wednesdayOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="thursdayIn", type="time")
     */
    private $thursdayIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="thursdayOut", type="time")
     */
    private $thursdayOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fridayIn", type="time")
     */
    private $fridayIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fridayOut", type="time")
     */
    private $fridayOut;

    public function __construct()
    {
        $this->isActive     = true;
        $this->roles        = ['ROLE_USER'];
        $this->createdAt    = new \DateTime();
        $this->updatedAt    = $this->createdAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * @param string $forename
     * @return $this
     */
    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
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
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate()
     *
     * @return User
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->getIsActive();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // not used because we will use bcrypt as encoder method
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->forename,
            $this->surname,
            $this->username,
            $this->password,
            $this->isActive,
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->forename,
            $this->surname,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }

    public function __toString()
    {
        return $this->getSurname() . ", " . $this->getForename();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set mondayIn
     *
     * @param \DateTime $mondayIn
     *
     * @return User
     */
    public function setMondayIn($mondayIn)
    {
        $this->mondayIn = $mondayIn;

        return $this;
    }

    /**
     * Get mondayIn
     *
     * @return \DateTime
     */
    public function getMondayIn()
    {
        return $this->mondayIn;
    }

    /**
     * Set mondayOut
     *
     * @param \DateTime $mondayOut
     *
     * @return User
     */
    public function setMondayOut($mondayOut)
    {
        $this->mondayOut = $mondayOut;

        return $this;
    }

    /**
     * Get mondayOut
     *
     * @return \DateTime
     */
    public function getMondayOut()
    {
        return $this->mondayOut;
    }

    /**
     * Set tuesdayIn
     *
     * @param \DateTime $tuesdayIn
     *
     * @return User
     */
    public function setTuesdayIn($tuesdayIn)
    {
        $this->tuesdayIn = $tuesdayIn;

        return $this;
    }

    /**
     * Get tuesdayIn
     *
     * @return \DateTime
     */
    public function getTuesdayIn()
    {
        return $this->tuesdayIn;
    }

    /**
     * Set tuesdayOut
     *
     * @param \DateTime $tuesdayOut
     *
     * @return User
     */
    public function setTuesdayOut($tuesdayOut)
    {
        $this->tuesdayOut = $tuesdayOut;

        return $this;
    }

    /**
     * Get tuesdayOut
     *
     * @return \DateTime
     */
    public function getTuesdayOut()
    {
        return $this->tuesdayOut;
    }

    /**
     * Set wednesdayIn
     *
     * @param \DateTime $wednesdayIn
     *
     * @return User
     */
    public function setWednesdayIn($wednesdayIn)
    {
        $this->wednesdayIn = $wednesdayIn;

        return $this;
    }

    /**
     * Get wednesdayIn
     *
     * @return \DateTime
     */
    public function getWednesdayIn()
    {
        return $this->wednesdayIn;
    }

    /**
     * Set wednesdayOut
     *
     * @param \DateTime $wednesdayOut
     *
     * @return User
     */
    public function setWednesdayOut($wednesdayOut)
    {
        $this->wednesdayOut = $wednesdayOut;

        return $this;
    }

    /**
     * Get wednesdayOut
     *
     * @return \DateTime
     */
    public function getWednesdayOut()
    {
        return $this->wednesdayOut;
    }

    /**
     * Set thursdayIn
     *
     * @param \DateTime $thursdayIn
     *
     * @return User
     */
    public function setThursdayIn($thursdayIn)
    {
        $this->thursdayIn = $thursdayIn;

        return $this;
    }

    /**
     * Get thursdayIn
     *
     * @return \DateTime
     */
    public function getThursdayIn()
    {
        return $this->thursdayIn;
    }

    /**
     * Set thursdayOut
     *
     * @param \DateTime $thursdayOut
     *
     * @return User
     */
    public function setThursdayOut($thursdayOut)
    {
        $this->thursdayOut = $thursdayOut;

        return $this;
    }

    /**
     * Get thursdayOut
     *
     * @return \DateTime
     */
    public function getThursdayOut()
    {
        return $this->thursdayOut;
    }

    /**
     * Set fridayIn
     *
     * @param \DateTime $fridayIn
     *
     * @return User
     */
    public function setFridayIn($fridayIn)
    {
        $this->fridayIn = $fridayIn;

        return $this;
    }

    /**
     * Get fridayIn
     *
     * @return \DateTime
     */
    public function getFridayIn()
    {
        return $this->fridayIn;
    }

    /**
     * Set fridayOut
     *
     * @param \DateTime $fridayOut
     *
     * @return User
     */
    public function setFridayOut($fridayOut)
    {
        $this->fridayOut = $fridayOut;

        return $this;
    }

    /**
     * Get fridayOut
     *
     * @return \DateTime
     */
    public function getFridayOut()
    {
        return $this->fridayOut;
    }
}
