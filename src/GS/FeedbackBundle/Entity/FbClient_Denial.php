<?php

namespace GS\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GS\FeedbackBundle\Entity\Feedback as Feedback;

/**
 * FbClient_Denial
 *
 * @ORM\Table(name="gs_feedback_client_denial")
 * @ORM\Entity(repositoryClass="GS\FeedbackBundle\Repository\FbClient_DenialRepository")
 */
class FbClient_Denial extends Feedback
{

    /**
     * @ORM\ManyToOne(targetEntity="FeedbackSet", inversedBy="fbClient_Denial")
     * @ORM\JoinColumn(name="feedback_set_id", referencedColumnName="id", unique=false)
     */
    private $feedbackSet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="GS\MailerBundle\Entity\Gender", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $gender;

    public function stringTitle()
    {
        return "questionnaire de refus client";
    }

    public function getType()
    {
        return 3;
    }

    public function stringName()
    {
        if($this->gender == null)
            return null;
        return $this->gender->getName()." ".$this->lastName;
    }

    // /**
    //  * Get id.
    //  *
    //  * @return int
    //  */
    // public function getId()
    // {
    //     return $this->id;
    // }

    // /**
    //  * Set creationDate.
    //  *
    //  * @param \DateTime $creationDate
    //  *
    //  * @return FbClient_Denial
    //  */
    // public function setCreationDate($creationDate)
    // {
    //     $this->creationDate = $creationDate;
    //
    //     return $this;
    // }
    //
    // /**
    //  * Get creationDate.
    //  *
    //  * @return \DateTime
    //  */
    // public function getCreationDate()
    // {
    //     return $this->creationDate;
    // }
    //
    // /**
    //  * Set responseDate.
    //  *
    //  * @param \DateTime $responseDate
    //  *
    //  * @return FbClient_Denial
    //  */
    // public function setResponseDate($responseDate)
    // {
    //     $this->responseDate = $responseDate;
    //
    //     return $this;
    // }
    //
    // /**
    //  * Get responseDate.
    //  *
    //  * @return \DateTime
    //  */
    // public function getResponseDate()
    // {
    //     return $this->responseDate;
    // }

    /**
     * Set feedbackSet.
     *
     * @param \GS\FeedbackBundle\Entity\FeedbackSet|null $feedbackSet
     *
     * @return FbClient_Denial
     */
    public function setFeedbackSet(\GS\FeedbackBundle\Entity\FeedbackSet $feedbackSet = null)
    {
        $this->feedbackSet = $feedbackSet;

        return $this;
    }

    /**
     * Get feedbackSet.
     *
     * @return \GS\FeedbackBundle\Entity\FeedbackSet|null
     */
    public function getFeedbackSet()
    {
        return $this->feedbackSet;
    }

    /**
     * Set token.
     *
     * @param \GS\FeedbackBundle\Entity\Token|null $token
     *
     * @return FbClient_Denial
     */
    public function setToken(\GS\FeedbackBundle\Entity\Token $token = null)
    {
        $this->token = $token;
        $token->setFeedback($this);

        return $this;
    }

    /**
     * Get token.
     *
     * @return \GS\FeedbackBundle\Entity\Token|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return FbClient_Denial
     */
    public function setLastName($lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender.
     *
     * @param \GS\MailerBundle\Entity\Gender|null $gender
     *
     * @return FbClient_Denial
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
