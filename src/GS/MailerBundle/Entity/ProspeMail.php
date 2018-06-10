<?php

namespace GS\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProspeMail
 *
 * @ORM\Table(name="gs_prospe_mail")
 * @ORM\Entity(repositoryClass="GS\MailerBundle\Repository\ProspeMailRepository")
 */
class ProspeMail
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
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sendAsUser;

    /**
     * @ORM\ManyToOne(targetEntity="GS\MailerBundle\Entity\State")
     * @ORM\JoinColumn(nullable=true)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="GS\MailBundle\Entity\Mail")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mail;




    public function __construct(){
        $this->creationDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
    }

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
}
