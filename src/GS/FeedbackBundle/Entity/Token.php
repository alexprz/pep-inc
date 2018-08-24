<?php

namespace GS\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GS\FeedbackBundle\Entity\Feedback;

/**
 * Token
 *
 * @ORM\Table(name="gs_feedback_token")
 * @ORM\Entity(repositoryClass="GS\FeedbackBundle\Repository\TokenRepository")
 */
class Token
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
     * @ORM\Column(name="string", type="string", length=255, unique=true)
     */
    private $string;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ExpirationDate", type="datetime", nullable=true)
     */
    private $expirationDate;

    /**
     * @ORM\OneToOne(targetEntity="Feedback", inversedBy="token")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $feedback;


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
     * Set string.
     *
     * @param string $string
     *
     * @return Token
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string.
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set expirationDate.
     *
     * @param \DateTime|null $expirationDate
     *
     * @return Token
     */
    public function setExpirationDate($expirationDate = null)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate.
     *
     * @return \DateTime|null
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set feedback.
     *
     * @param \GS\FeedbackBundle\Entity\Feedback|null $feedback
     *
     * @return Token
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
