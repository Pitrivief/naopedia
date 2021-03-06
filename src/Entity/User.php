<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;





/**
* @ORM\Entity(repositoryClass="App\Repository\UserRepository")
* @UniqueEntity(fields="username", message="Un utilisateur existe déjà avec ce nom")
* @UniqueEntity(fields="email", message="Un utilisateur existe déjà avec cet email")
 * @Vich\Uploadable
*/
class User  implements UserInterface, \Serializable
{
  /**
  * @ORM\Id
  * @ORM\GeneratedValue
  * @ORM\Column(type="integer")
  */
  private $id;

  /**
  * @ORM\Column(type="string",  length=25, unique=true)
  */
  private $username;

  /**
  * @ORM\Column(type="string")
  */
  private $password;

  /**
  * @ORM\Column(type="string")
  */
  private $avatar;

  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $bio;
          
  /**
   * @Vich\UploadableField(mapping="images", fileNameProperty="avatar")
   * @var File
   */
  private $avatarFile;

  /**
  * @ORM\Column(type="string", unique=true)
  */
  private $email;

  /**
  * @ORM\Column(type="string")
  */
  private $salt;


  /**
  * @ORM\Column(type="string", nullable=true)
  */
  protected $confirmationToken;     // Random string sent to the user email address in order to verify it.

  /**
  *@ORM\Column(type="datetime", nullable=true)
  */
  protected $passwordRequestedAt;

  /**
  * @ORM\Column(type="array")
  */
  protected $roles;

  /**
  * @ORM\OneToMany(targetEntity="App\Entity\Image",mappedBy="author")
  */
  protected $images;

  /**
   *
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $createdAt;

  /**
  * @ORM\OneToMany(targetEntity="App\Entity\Observation",mappedBy="user")
  */
  private $observations;
  
  /**
   *
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $updatedAt;


  protected static $rolesParameter = ['ROLE_ADMIN_SUPER' =>'Super Administrateur','ROLE_ADMIN' =>'Administrateur','ROLE_NATURALISTE' =>'Naturaliste','ROLE_REDACTEUR' =>'Redacteur', 'ROLE_USER' =>'Observateur'];

  /**
  * Get the value of Id
  *
  * @return mixed
  */
  public function getId()
  {
    return $this->id;
  }

  public function eraseCredentials()
{
}

public function __toString()
{
    return $this->getUsername();
}

public function getFormatedRoles()
{
  $roles = $this->getRoles();
  $formatedRoles = '';
  foreach($roles as $role){
    $formatedRoles.= self::$rolesParameter[$role].", ";
  }
  $formatedRoles = substr($formatedRoles, 0, -2);
  return $formatedRoles;
}

  public function setAvatarFile(File $avatarFile = null) {
      $this->avatarFile = $avatarFile;
      if ($avatarFile) {
          $this->updatedAt = new \DateTime('now');
      }
      return $this;
  }

  /**
  * Set the value of Id
  *
  * @param mixed id
  *
  * @return self
  */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
  * Get the value of Password
  *
  * @return mixed
  */
  public function getPassword()
  {
    return $this->password;
  }

  /**
  * Set the value of Password
  *
  * @param mixed password
  *
  * @return self
  */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
  * Get the value of Email
  *
  * @return mixed
  */
  public function getEmail()
  {
    return $this->email;
  }

  /**
  * Set the value of Email
  *
  * @param mixed email
  *
  * @return self
  */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
  * Get the value of Salt
  *
  * @return mixed
  */
  public function getSalt()
  {
    return $this->salt;
  }

  /**
  * Set the value of Salt
  *
  * @param mixed salt
  *
  * @return self
  */
  public function setSalt($salt)
  {
    $this->salt = $salt;

    return $this;
  }

  /**
  * Get the value of Confirmation Token
  *
  * @return mixed
  */
  public function getConfirmationToken()
  {
    return $this->confirmationToken;
  }

  /**
  * Set the value of Confirmation Token
  *
  * @param mixed confirmationToken
  *
  * @return self
  */
  public function setConfirmationToken($confirmationToken)
  {
    $this->confirmationToken = $confirmationToken;

    return $this;
  }

  /**
  * Get the value of Password Requested At
  *
  * @return mixed
  */
  public function getPasswordRequestedAt()
  {
    return $this->passwordRequestedAt;
  }

  /**
  * Set the value of Password Requested At
  *
  * @param mixed passwordRequestedAt
  *
  * @return self
  */
  public function setPasswordRequestedAt($passwordRequestedAt)
  {
    $this->passwordRequestedAt = $passwordRequestedAt;

    return $this;
  }


  /**
  * Get the value of Images
  *
  * @return mixed
  */
  public function getImages()
  {
    return $this->images;
  }

  /**
  * Set the value of Images
  *
  * @param mixed images
  *
  * @return self
  */
  public function setImages($images)
  {
    $this->images = $images;

    return $this;
  }

  public function __construct()
      {
          $this->images = new ArrayCollection();
      }

  /** @see \Serializable::serialize() */
  public function serialize()
  {
      return serialize(array(
          $this->id,
          $this->username,
          $this->password,
          // see section on salt below
           $this->salt,
      ));
  }

  /** @see \Serializable::unserialize() */
  public function unserialize($serialized)
  {
      list (
          $this->id,
          $this->username,
          $this->password,
          // see section on salt below
           $this->salt
      ) = unserialize($serialized);
  }

    /**
     * Get the value of Avatar
     *
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of Avatar
     *
     * @param mixed avatar
     *
     * @return self
     */
    public function tar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }





    /**
     * Get the value of Username
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of Username
     *
     * @param mixed username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of Roles
     *
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of Roles
     *
     * @param mixed roles
     *
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * Get the value of Avatar File
     *
     * @return File
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }


    /**
     * Get the value of Roles Parameter
     *
     * @return mixed
     */
    public function getRolesParameter()
    {
        return $this->rolesParameter;
    }

    /**
     * Set the value of Roles Parameter
     *
     * @param mixed rolesParameter
     *
     * @return self
     */
    public function setRolesParameter($rolesParameter)
    {
        $this->rolesParameter = $rolesParameter;

        return $this;
    }



    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    /**
     * Set the value of Avatar
     *
     * @param mixed avatar
     *
     * @return self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }
    
    public function getBio() {
        return $this->bio;
    }

    public function setBio($bio) {
        $this->bio = $bio;
        return $this;
    }

    public function getObservations() {
        return $this->observations;
    }

    public function setObservations($observations) {
        $this->observations = $observations;
        return $this;
    }



}
