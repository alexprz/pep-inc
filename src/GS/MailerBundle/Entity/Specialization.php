<?php

namespace GS\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialization
 *
 * @ORM\Table(name="gs_prospe_mail_specialization")
 * @ORM\Entity(repositoryClass="GS\MailerBundle\Repository\SpecializationRepository")
 */
class Specialization
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sortCode", type="integer", nullable=true)
     */
    private $sortCode;


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
     * Set name.
     *
     * @param string|null $name
     *
     * @return Specialization
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sortCode.
     *
     * @param int|null $sortCode
     *
     * @return Specialization
     */
    public function setSortCode($sortCode = null)
    {
        $this->sortCode = $sortCode;

        return $this;
    }

    /**
     * Get sortCode.
     *
     * @return int|null
     */
    public function getSortCode()
    {
        return $this->sortCode;
    }
}
