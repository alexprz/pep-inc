<?php

namespace GS\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// use \Zend\Stdlib\JsonSerializable;

/**
 * Mail
 *
 * @ORM\Table(name="gs_mail_old")
 * @ORM\Entity(repositoryClass="GS\MailerBundle\Repository\MailRepository")
 */
class Mail// implements JsonSerializable
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
     * @var string
     *
     * @ORM\Column(name="fromEmail", type="string", length=255, nullable=true)
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="fromAlias", type="string", length=255, nullable=true)
     */
    private $fromAlias;

    /**
     * @var string
     *
     * @ORM\Column(name="recipientEmail", type="string", length=255, nullable=true)
     */
    private $recipientEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255, nullable=true)
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduledDate", type="datetime", length=255, nullable=true)
     */
    private $scheduledDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sentAt", type="datetime", length=255, nullable=true)
     */
    private $sentAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="sent", type="boolean", nullable=true)
     */
    private $sent;

    /**
     * @var bool
     *
     * @ORM\Column(name="error", type="boolean", nullable=true)
     */
    private $error;

    /**
     * @var bool
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var bool
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sendAsUser;

    /**
     * @var string
     * @ORM\Column(name="company", type="string", nullable=true)
     */
    private $company;

    /**
     * @var string
     * @ORM\Column(name="specialization", type="string", nullable=true)
     */
    private $specialization;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="recipientName", type="string", nullable=true)
     */
    private $recipientName;

    /**
     * @var bool
     * @ORM\ManyToOne(targetEntity="GS\MailerBundle\Entity\State")
     * @ORM\JoinColumn(nullable=true)
     */
    private $state;


    public function __construct(){
        $this->creationDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
    }

    // public function toJson () {
    //     return array(
    //         'id'=>$this->id,
    //         'fromEmail'=>$this->fromEmail,
    //         'fromAlias'=>$this->fromAlias,
    //         'recipientEmail'=>$this->recipientEmail,
    //         'object'=>$this->object,
    //         'content'=>$this->content,
    //         'creationDate'=>$this->creationDate,
    //         'scheduledDate'=>$this->scheduledDate,
    //         'sentAt'=>$this->sentAt,
    //         'sent'=>$this->sent,
    //         'error'=>$this->error,
    //         'user'=>json_encode($this->user),
    //         'state'=>$this->state->getJson()
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
     * Set fromEmail.
     *
     * @param string $fromEmail
     *
     * @return Mail
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail.
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set fromAlias.
     *
     * @param string $fromAlias
     *
     * @return Mail
     */
    public function setFromAlias($fromAlias)
    {
        $this->fromAlias = $fromAlias;

        return $this;
    }

    /**
     * Get fromAlias.
     *
     * @return string
     */
    public function getFromAlias()
    {
        return $this->fromAlias;
    }

    /**
     * Set recipientEmail.
     *
     * @param string $recipientEmail
     *
     * @return Mail
     */
    public function setRecipientEmail($recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;

        return $this;
    }

    /**
     * Get recipientEmail.
     *
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->recipientEmail;
    }

    /**
     * Set object.
     *
     * @param string $object
     *
     * @return Mail
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object.
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Mail
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Mail
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
     * Set sendDate.
     *
     * @param string $sendDate
     *
     * @return Mail
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * Get sendDate.
     *
     * @return string
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Set sent.
     *
     * @param bool $sent
     *
     * @return Mail
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        if($sent){
            $this->setSendDate(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));
        }

        return $this;
    }

    /**
     * Get sent.
     *
     * @return bool
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set error.
     *
     * @param bool $error
     *
     * @return Mail
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error.
     *
     * @return bool
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set user.
     *
     * @param \GS\UserBundle\Entity\User $user
     *
     * @return Mail
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
     * Set scheduledDate.
     *
     * @param \DateTime|null $scheduledDate
     *
     * @return Mail
     */
    public function setScheduledDate($scheduledDate = null)
    {
        $this->scheduledDate = $scheduledDate;

        return $this;
    }

    /**
     * Get scheduledDate.
     *
     * @return \DateTime|null
     */
    public function getScheduledDate()
    {
        return $this->scheduledDate;
    }

    /**
     * Set sentDate.
     *
     * @param \DateTime|null $sentDate
     *
     * @return Mail
     */
    public function setSentDate($sentDate = null)
    {
        $this->sentDate = $sentDate;

        return $this;
    }

    /**
     * Get sentDate.
     *
     * @return \DateTime|null
     */
    public function getSentDate()
    {
        return $this->sentDate;
    }

    /**
     * Set sentAt.
     *
     * @param \DateTime|null $sentAt
     *
     * @return Mail
     */
    public function setSentAt($sentAt = null)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Get sentAt.
     *
     * @return \DateTime|null
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Set state.
     *
     * @param \GS\MailerBundle\Entity\State|null $state
     *
     * @return Mail
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
     * Set sendAsUser.
     *
     * @param \GS\UserBundle\Entity\User|null $sendAsUser
     *
     * @return Mail
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
     * Set company.
     *
     * @param string|null $company
     *
     * @return Mail
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
     * Set specialization.
     *
     * @param string|null $specialization
     *
     * @return Mail
     */
    public function setSpecialization($specialization = null)
    {
        $this->specialization = $specialization;

        return $this;
    }

    /**
     * Get specialization.
     *
     * @return string|null
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return Mail
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
     * Set recipientName.
     *
     * @param string|null $recipientName
     *
     * @return Mail
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
}
