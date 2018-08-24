<?php

namespace GS\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="gs_feedback_question")
 * @ORM\Entity(repositoryClass="GS\FeedbackBundle\Repository\QuestionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Question
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
     * @var bool|null
     *
     * @ORM\Column(name="booleanAnswer", type="boolean", nullable=true)
     */
    private $booleanAnswer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="textAnswer", type="text", nullable=true)
     */
    private $textAnswer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
    * @ORM\ManyToOne(targetEntity="GS\FeedbackBundle\Entity\QuestionModel")
    * @ORM\JoinColumn(nullable=true)
     */
    private $questionModel;

    /**
     * @ORM\ManyToOne(targetEntity="Feedback", inversedBy="question")
     * @ORM\JoinColumn(name="feedback_id", referencedColumnName="id", unique=false)
     */
    private $feedback;

    public function __construct()
    {
        $this->creationDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
    }

    public function stringBooleanAnswer()
    {
        if($this->questionModel != null)
        {
            if ($this->booleanAnswer == null)
                return "Sans avis";
            else if($this->booleanAnswer == false)
                return "Non";
            else if($this->booleanAnswer == true)
                return "Oui";
        }
        return "";
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
     * @param string|null $title
     *
     * @return Question
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
     * Set booleanAnswer.
     *
     * @param bool|null $booleanAnswer
     *
     * @return Question
     */
    public function setBooleanAnswer($booleanAnswer = null)
    {
        $this->booleanAnswer = $booleanAnswer;

        return $this;
    }

    /**
     * Get booleanAnswer.
     *
     * @return bool|null
     */
    public function getBooleanAnswer()
    {
        return $this->booleanAnswer;
    }

    /**
     * Set textAnswer.
     *
     * @param string|null $textAnswer
     *
     * @return Question
     */
    public function setTextAnswer($textAnswer = null)
    {
        $this->textAnswer = $textAnswer;

        return $this;
    }

    /**
     * Get textAnswer.
     *
     * @return string|null
     */
    public function getTextAnswer()
    {
        return $this->textAnswer;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Question
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
     * Set questionModel.
     *
     * @param \GS\FeedbackBundle\Entity\QuestionModel|null $questionModel
     *
     * @return Question
     */
    public function setQuestionModel(\GS\FeedbackBundle\Entity\QuestionModel $questionModel = null)
    {
        $this->questionModel = $questionModel;

        return $this;
    }

    /**
     * Get questionModel.
     *
     * @return \GS\FeedbackBundle\Entity\QuestionModel|null
     */
    public function getQuestionModel()
    {
        return $this->questionModel;
    }

    /**
     * Set feedback.
     *
     * @param \GS\FeedbackBundle\Entity\Feedback|null $feedback
     *
     * @return Question
     */
    public function setFeedback(\GS\FeedbackBundle\Entity\Feedback $feedback = null)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get feedback.
     *
     * @return \GS\FeedbackBundle\Entity\Feedback|null
     */
    public function getFeedback()
    {
        return $this->feedback;
    }
}
