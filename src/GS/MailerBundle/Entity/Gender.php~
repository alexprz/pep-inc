<?php

namespace GS\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gender
 *
 * @ORM\Table(name="gs_prospe_mail_gender")
 * @ORM\Entity(repositoryClass="GS\MailerBundle\Repository\GenderRepository")
 */
class Gender implements \JsonSerializable
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

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
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
     * Set name.
     *
     * @param string|null $name
     *
     * @return Gender
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
     * @return Gender
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
