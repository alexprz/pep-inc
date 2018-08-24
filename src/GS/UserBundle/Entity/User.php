<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="gs_user")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
   protected $id;

   /**
      * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
      *
      * @Assert\NotBlank(message="Veuillez renseigner un nom.")
      */
      protected $lastName;

    /**
      * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
      *
      * @Assert\NotBlank(message="Veuillez renseigner un prénom.")
      */
      protected $firstName;

    /**
      * @ORM\Column(name="phone", type="string", length=255, nullable=true)
      *
      */
      protected $phone;

    /**
      * @ORM\Column(name="mail_pro", type="string", length=255, nullable=false)
      */
      protected $mail_pro;

    /**
      * @ORM\Column(name="mail_perso", type="string", length=255, nullable=true)
      */
      protected $mail_perso;

    /**
      * @ORM\Column(name="promo", type="integer", nullable=true)
      */
      protected $promo;

    /**
      * @ORM\Column(name="creation_date", type="date", nullable=true)
      */
      protected $creation_date;

    /**
      * @ORM\Column(name="expiration_date", type="date", nullable=true)
      *
      *  @Assert\NotBlank(message="Veuillez renseigner une date d'expiration du compte.", groups={"Registration"})
      */
      protected $expiration_date;

    /**
      * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\Post")
      * @ORM\JoinColumn(nullable=true)
      */
      protected $post;

      /**
        * @ORM\ManyToOne(targetEntity="GS\MailerBundle\Entity\Gender")
        * @ORM\JoinColumn(nullable=true)
        */
        protected $gender;


     //OVERWRITTING
     //Permet de ne pas tenir compte de l'username (login avec email unqiuement)

     public function __construct()
     {
       parent::__construct();
       $this->creation_date = new \DateTime();
       $this->expiration_date = new \DateTime();
     }

     public function stringName()
     {
        $string = "";
        if($this->firstName != null){
            $string = ucfirst($this->firstName);
            if($this->lastName != null)
                $string = $string." ".strtoupper($this->lastName);
        }
        return $string;
     }

     public function isAdmin()
     {
         return $this->hasRole('ROLE_ADMIN') || $this->hasRole('ROLE_SUPER_ADMIN');
     }

     /**
     * Sets the email.
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        //Le nom d'utilisateur et le mail pro est le mail renseigné par l'admin lors de l'inscription
        $this->setUsername($email);
        $this->setMailPro($email);

        return parent::setEmail($email);
    }

    /**
     * Set the canonical email.
     *
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->setUsernameCanonical($emailCanonical);

        return parent::setEmailCanonical($emailCanonical);
    }

    public function setPassword($password)
    {
      // $this->password = $this->last_name;
      return parent::setPassword($password);
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = mb_strtoupper($lastName);

        //Enlève les accents et carcatères spéciaux et met en minuscule
        $string = iconv ('UTF-8', 'US-ASCII//TRANSLIT//IGNORE', $lastName);
        $string = preg_replace ('#[^.0-9a-z]+#i', '', $string);
        $string = strtolower ($string);

        return parent::setPlainPassword($string);
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = ucfirst(strtolower($firstName));

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return User
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mailPro.
     *
     * @param string|null $mailPro
     *
     * @return User
     */
    public function setMailPro($mailPro = null)
    {
        $this->mail_pro = $mailPro;

        return $this;
    }

    /**
     * Get mailPro.
     *
     * @return string|null
     */
    public function getMailPro()
    {
        return $this->mail_pro;
    }

    /**
     * Set mailPerso.
     *
     * @param string|null $mailPerso
     *
     * @return User
     */
    public function setMailPerso($mailPerso = null)
    {
        $this->mail_perso = $mailPerso;

        return $this;
    }

    /**
     * Get mailPerso.
     *
     * @return string|null
     */
    public function getMailPerso()
    {
        return $this->mail_perso;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime|null $creationDate
     *
     * @return User
     */
    public function setCreationDate($creationDate = null)
    {
        $this->creation_date = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime|null
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set expirationDate.
     *
     * @param \DateTime|null $expirationDate
     *
     * @return User
     */
    public function setExpirationDate($expirationDate = null)
    {
        $this->expiration_date = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate.
     *
     * @return \DateTime|null
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * Set post.
     *
     * @param \GS\UserBundle\Entity\Post $post
     *
     * @return User
     */
    public function setPost(\GS\UserBundle\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post.
     *
     * @return \JE\PlatformBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set promo.
     *
     * @param int|null $promo
     *
     * @return User
     */
    public function setPromo($promo = null)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo.
     *
     * @return int|null
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set gender.
     *
     * @param \GS\MailerBundle\Entity\Gender|null $gender
     *
     * @return User
     */
    public function setGender(\GS\MailerBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return \GS\MailerBundle\Entity\Gender|null
     */
    public function getGender()
    {
        return $this->gender;
    }
}
