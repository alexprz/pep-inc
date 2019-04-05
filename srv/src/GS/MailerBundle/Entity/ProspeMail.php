<?php

namespace GS\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProspeMail
 *
 * @ORM\Table(name="gs_prospe_mail")
 * @ORM\Entity(repositoryClass="GS\MailerBundle\Repository\ProspeMailRepository")
 */
class ProspeMail implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User", cascade={"detach"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $sendAsUser;

    /**
     * @ORM\ManyToOne(targetEntity="GS\MailerBundle\Entity\State")
     * @ORM\JoinColumn(nullable=true)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="GS\MailBundle\Entity\Mail", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $mail;

    /**
     * @var string
     * @ORM\Column(name="recipientName", type="string", nullable=true)
     */
    private $recipientName;

    /**
     * @ORM\ManyToOne(targetEntity="GS\MailerBundle\Entity\Gender", cascade={"detach"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $gender;

    /**
     * @var string
     * @ORM\Column(name="company", type="string", nullable=true)
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity="GS\MailerBundle\Entity\Specialization", cascade={"detach"})
     *
     */
    private $specialization;




    public function __construct(){
        $this->creationDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        // return json_encode($this);
        return $vars;
    }

    // public static function fromStdClass(\stdClass $entry)
    // {
    //     return new self(
    //
    //     );
    // }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return ProspeMail
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set user.
     *
     * @param \GS\UserBundle\Entity\User $user
     *
     * @return ProspeMail
     */
    public function setUser(\GS\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \GS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set sendAsUser.
     *
     * @param \GS\UserBundle\Entity\User|null $sendAsUser
     *
     * @return ProspeMail
     */
    public function setSendAsUser(\GS\UserBundle\Entity\User $sendAsUser = null)
    {
        $this->sendAsUser = $sendAsUser;

        return $this;
    }

    /**
     * Get sendAsUser.
     *
     * @return \GS\UserBundle\Entity\User|null
     */
    public function getSendAsUser()
    {
        return $this->sendAsUser;
    }

    /**
     * Set state.
     *
     * @param \GS\MailerBundle\Entity\State|null $state
     *
     * @return ProspeMail
     */
    public function setState(\GS\MailerBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return \GS\MailerBundle\Entity\State|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set mail.
     *
     * @param \GS\MailBundle\Entity\Mail|null $mail
     *
     * @return ProspeMail
     */
    public function setMail(\GS\MailBundle\Entity\Mail $mail = null)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return \GS\MailBundle\Entity\Mail|null
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set recipientName.
     *
     * @param string|null $recipientName
     *
     * @return ProspeMail
     */
    public function setRecipientName($recipientName = null)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * Get recipientName.
     *
     * @return string|null
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return ProspeMail
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set company.
     *
     * @param string|null $company
     *
     * @return ProspeMail
     */
    public function setCompany($company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company.
     *
     * @return string|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set gender.
     *
     * @param \GS\MailerBundle\Entity\Gender|null $gender
     *
     * @return ProspeMail
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

    // /**
    //  * Set specialization.
    //  *
    //  * @param \GS\MailerBundle\Entity\Specialization|null $specialization
    //  *
    //  * @return ProspeMail
    //  */
    // public function setSpecialization(\GS\MailerBundle\Entity\Specialization $specialization = null)
    // {
    //     $this->specialization = $specialization;
    //
    //     return $this;
    // }
    //
    // /**
    //  * Get specialization.
    //  *
    //  * @return \GS\MailerBundle\Entity\Specialization|null
    //  */
    // public function getSpecialization()
    // {
    //     return $this->specialization;
    // }



    /**
     * Add specialization.
     *
     * @param \GS\MailerBundle\Entity\Specialization $specialization
     *
     * @return ProspeMail
     */
    public function addSpecialization(\GS\MailerBundle\Entity\Specialization $specialization)
    {
        $this->specialization[] = $specialization;

        return $this;
    }

    /**
     * Remove specialization.
     *
     * @param \GS\MailerBundle\Entity\Specialization $specialization
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSpecialization(\GS\MailerBundle\Entity\Specialization $specialization)
    {
        return $this->specialization->removeElement($specialization);
    }

    /**
     * Get specialization.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    public function setSpecialization($specializationArray)
    {
        $this->specialization = $specializationArray;

        return $this;
    }
}
