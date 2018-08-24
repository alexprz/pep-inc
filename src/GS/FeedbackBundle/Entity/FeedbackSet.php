<?php

namespace GS\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * FeedbackSet
 *
 * @ORM\Table(name="gs_feedback_set")
 * @ORM\Entity(repositoryClass="GS\FeedbackBundle\Repository\FeedbackSetRepository")
 */
class FeedbackSet
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\OneToMany(targetEntity="FbStudent", mappedBy="feedbackSet", cascade={"persist", "remove"})
     */
    private $fbStudent;

    /**
     * @ORM\OneToMany(targetEntity="FbClient", mappedBy="feedbackSet", cascade={"persist", "remove"})
     */
    private $fbClient;

    /**
     * @ORM\OneToMany(targetEntity="FbClient_Denial", mappedBy="feedbackSet", cascade={"persist", "remove"})
     */
    private $fbClient_Denial;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct() {
        $this->creationDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));

        $this->fbStudent = new ArrayCollection();
        $this->fbClient = new ArrayCollection();
        $this->fbClient_Denial = new ArrayCollection();
    }

    public function addFeedback($fb)
    {
        if($fb instanceof \GS\FeedbackBundle\Entity\FbStudent)
            $this->addFbStudent($fb);
        else if($fb instanceof \GS\FeedbackBundle\Entity\FbClient)
            $this->addFbClient($fb);
        else if($fb instanceof \GS\FeedbackBundle\Entity\FbClient_Denial)
            $this->addFbClientDenial($fb);
    }

    public function removeFeedback($fb)
    {
        if($fb instanceof \GS\FeedbackBundle\Entity\FbStudent)
            $this->removeFbStudent($fb);
        else if($fb instanceof \GS\FeedbackBundle\Entity\FbClient)
            $this->removeFbClient($fb);
        else if($fb instanceof \GS\FeedbackBundle\Entity\FbClient_Denial)
            $this->removeFbClientDenial($fb);
    }

    public function countAllFeedbacks()
    {
        return count($this->fbStudent) + count($this->fbClient) + count($this->fbClient_Denial);
    }

    public function countSubmittedFeedbacks()
    {
        $k = 0;
        for ($i=0; $i < count($this->fbStudent); $i++) {
            if($this->fbStudent[$i]->isSubmitted())
                $k++;
        }
        for ($i=0; $i < count($this->fbClient); $i++) {
            if($this->fbClient[$i]->isSubmitted())
                $k++;
        }
        for ($i=0; $i < count($this->fbClient_Denial); $i++) {
            if($this->fbClient_Denial[$i]->isSubmitted())
                $k++;
        }
        return $k;
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
     * Set title.
     *
     * @param string $title
     *
     * @return FeedbackSet
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return FeedbackSet
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
     * Add fbStudent.
     *
     * @param \GS\FeedbackBundle\Entity\FbStudent $fbStudent
     *
     * @return FeedbackSet
     */
    public function addFbStudent(\GS\FeedbackBundle\Entity\FbStudent $fbStudent)
    {
        $this->fbStudent[] = $fbStudent;
        $fbStudent->setFeedbackSet($this);
        return $this;
    }

    /**
     * Remove fbStudent.
     *
     * @param \GS\FeedbackBundle\Entity\FbStudent $fbStudent
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFbStudent(\GS\FeedbackBundle\Entity\FbStudent $fbStudent)
    {
        $fbStudent->setFeedbackSet(null);
        return $this->fbStudent->removeElement($fbStudent);
    }

    /**
     * Get fbStudent.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFbStudent()
    {
        return $this->fbStudent;
    }

    /**
     * Add fbClient.
     *
     * @param \GS\FeedbackBundle\Entity\FbClient $fbClient
     *
     * @return FeedbackSet
     */
    public function addFbClient(\GS\FeedbackBundle\Entity\FbClient $fbClient)
    {
        $this->fbClient[] = $fbClient;
        $fbClient->setFeedbackSet($this);

        return $this;
    }

    /**
     * Remove fbClient.
     *
     * @param \GS\FeedbackBundle\Entity\FbClient $fbClient
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFbClient(\GS\FeedbackBundle\Entity\FbClient $fbClient)
    {
        $fbClient->setFeedbackSet(null);
        return $this->fbClient->removeElement($fbClient);
    }

    /**
     * Get fbClient.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFbClient()
    {
        return $this->fbClient;
    }

    /**
     * Add fbClientDenial.
     *
     * @param \GS\FeedbackBundle\Entity\FbClient_Denial $fbClientDenial
     *
     * @return FeedbackSet
     */
    public function addFbClientDenial(\GS\FeedbackBundle\Entity\FbClient_Denial $fbClientDenial)
    {
        $this->fbClient_Denial[] = $fbClientDenial;
        $fbClientDenial->setFeedbackSet($this);

        return $this;
    }

    /**
     * Remove fbClientDenial.
     *
     * @param \GS\FeedbackBundle\Entity\FbClient_Denial $fbClientDenial
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFbClientDenial(\GS\FeedbackBundle\Entity\FbClient_Denial $fbClientDenial)
    {
        $fbClientDenial->setFeedbackSet(null);
        return $this->fbClient_Denial->removeElement($fbClientDenial);
    }

    /**
     * Get fbClientDenial.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFbClientDenial()
    {
        return $this->fbClient_Denial;
    }

    /**
     * Set user.
     *
     * @param \GS\UserBundle\Entity\User $user
     *
     * @return FeedbackSet
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
}
