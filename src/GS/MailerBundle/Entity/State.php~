<?php

namespace GS\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// use \Zend\Stdlib\JsonSerializable;

/**
 * State
 *
 * @ORM\Table(name="gs_state")
 * @ORM\Entity(repositoryClass="GS\MailerBundle\Repository\StateRepository")
 */
class State//  implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sortCode", type="integer")
     */
    protected $sortCode;

    // public function toJson () {
    //     return array(
    //         'id'=>$this->id,
    //         'name'=>$this->name
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
     * Set name.
     *
     * @param string $name
     *
     * @return State
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sortCode.
     *
     * @param int $sortCode
     *
     * @return State
     */
    public function setSortCode($sortCode)
    {
        $this->sortCode = $sortCode;

        return $this;
    }

    /**
     * Get sortCode.
     *
     * @return int
     */
    public function getSortCode()
    {
        return $this->sortCode;
    }
}
