<?php

namespace GS\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GS\FeedbackBundle\Entity\Feedback as Feedback;

/**
 * FbStudent
 *
 * @ORM\Table(name="gs_feedback_student")
 * @ORM\Entity(repositoryClass="GS\FeedbackBundle\Repository\FbStudentRepository")
 */
class FbStudent extends Feedback
{

    /**
     * @ORM\ManyToOne(targetEntity="FeedbackSet", inversedBy="fbStudent")
     * @ORM\JoinColumn(name="feedback_set_id", referencedColumnName="id", unique=false)
     */
    private $feedbackSet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;




    public function stringTitle()
    {
        return "questionnaire de satisfaction étudiant";
    }
    public function stringTitleLight()
    {
        return "étudiant";
    }

    public function getType()
    {
        return 1;
    }

    public function stringName()
    {
        return $this->firstName." ".$this->lastName;
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
    //  * @return FbStudent
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
    //  * @return FbStudent
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
     * @return FbStudent
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
     * @return FbStudent
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
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return FbStudent
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return FbStudent
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
}
