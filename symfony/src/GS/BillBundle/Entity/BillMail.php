<?php

namespace GS\BillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BillMail
 *
 * @ORM\Table(name="gs_bill_mail")
 * @ORM\Entity(repositoryClass="GS\BillBundle\Repository\BillMailRepository")
 */
class BillMail
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
     * @ORM\ManyToOne(targetEntity="GS\MailBundle\Entity\Mail", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $mail;


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
     * Set mail.
     *
     * @param \GS\MailBundle\Entity\Mail|null $mail
     *
     * @return BillMail
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
