<?php

namespace GS\BillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Bill
 *
 * @ORM\Table(name="gs_bill")
 * @ORM\Entity(repositoryClass="GS\BillBundle\Repository\BillRepository")
 */
class Bill
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
     * @ORM\Column(name="clientName", type="string", length=255, nullable=true)
     */
    private $clientName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="billNumber", type="string", length=255, nullable=true)
     */
    private $billNumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dueDate", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var float|null
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="retryDate", type="datetime", nullable=true)
     */
    private $retryDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="paymentDate", type="datetime", nullable=true)
     */
    private $paymentDate;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="GS\BillBundle\Entity\BillState")
     * @ORM\JoinColumn(nullable=true)
     */
    private $billState;

    /**
     * @ORM\ManyToOne(targetEntity="GS\BillBundle\Entity\PaymentMeans")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paymentMean;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $followerMember;

    /**
     * @var string|null
     *
     * @ORM\Column(name="followerEmail", type="string", length=255, nullable=true)
     */
    private $followerEmail;

    /**
     * @ORM\ManyToOne(targetEntity="GS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $clientMember;

    /**
     * @ORM\ManyToOne(targetEntity="GS\BillBundle\Entity\BillType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $billType;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $billPdf;

    /**
      * @var \DateTime
      *
      * @ORM\Column(name="creation_date", type="datetime")
      */
    private $creationDate;

    public function __construct(){
        $this->creationDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
        $this->dueDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
    }

    public function isLate()
    {
        if($this->dueDate == null)
            return false;

        $todayDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
        return (!$this->isPaid() && $todayDate > $this->dueDate ) || ($this->isPaid() && $this->paymentDate > $this->dueDate );
    }

    public function isCancelled()
    {
        if($this->billState == null)
            return false;

        return $this->billState->getName() == "Annulée";
    }

    public function isPaid()
    {
        if($this->billState == null)
            return false;

        return $this->billState->getName() == "Payée";
    }

    public function getMail()
    {
        if($this->isMemberBill() && $this->getClientMember() != null)
            return $this->getClientMember()->getEmail();
        else if($this->isMemberBill())
            return "";

        if($this->getFollowerMember() != null)
            return $this->getFollowerMember()->getEmail();
        else
            return $this->followerEmail;
    }

    public function isClientBill()
    {
        if($this->getBillType() == null)
            return false;
        return $this->getBillType()->getName() == "Facture de vente";
    }

    public function isMemberBill()
    {
        if($this->getBillType() == null)
            return false;
        return $this->getBillType()->getName() == "Refacturation";
    }

    public function getRealClientName()
    {

        if($this->isClientBill())
            return $this->getClientName();
        else if($this->isMemberBill()){
            if($this->getClientMember() != null)
                return $this->getClientMember()->stringName();
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
     * Set clientName.
     *
     * @param string|null $clientName
     *
     * @return Bill
     */
    public function setClientName($clientName = null)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName.
     *
     * @return string|null
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set billNumber.
     *
     * @param string|null $billNumber
     *
     * @return Bill
     */
    public function setBillNumber($billNumber = null)
    {
        $this->billNumber = $billNumber;

        return $this;
    }

    /**
     * Get billNumber.
     *
     * @return string|null
     */
    public function getBillNumber()
    {
        return $this->billNumber;
    }

    /**
     * Set dueDate.
     *
     * @param \DateTime|null $dueDate
     *
     * @return Bill
     */
    public function setDueDate($dueDate = null)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate.
     *
     * @return \DateTime|null
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set amount.
     *
     * @param float|null $amount
     *
     * @return Bill
     */
    public function setAmount($amount = null)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set retryDate.
     *
     * @param \DateTime|null $retryDate
     *
     * @return Bill
     */
    public function setRetryDate($retryDate = null)
    {
        $this->retryDate = $retryDate;

        return $this;
    }

    /**
     * Get retryDate.
     *
     * @return \DateTime|null
     */
    public function getRetryDate()
    {
        return $this->retryDate;
    }

    /**
     * Set paymentDate.
     *
     * @param \DateTime|null $paymentDate
     *
     * @return Bill
     */
    public function setPaymentDate($paymentDate = null)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate.
     *
     * @return \DateTime|null
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Bill
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
     * Set user.
     *
     * @param \GS\UserBundle\Entity\User|null $user
     *
     * @return Bill
     */
    public function setUser(\GS\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \GS\UserBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set billState.
     *
     * @param \GS\BillBundle\Entity\billState|null $billState
     *
     * @return Bill
     */
    public function setBillState(\GS\BillBundle\Entity\billState $billState = null)
    {
        $this->billState = $billState;

        return $this;
    }

    /**
     * Get billState.
     *
     * @return \GS\BillBundle\Entity\billState|null
     */
    public function getBillState()
    {
        return $this->billState;
    }

    /**
     * Set paymentMean.
     *
     * @param \GS\BillBundle\Entity\paymentMeans|null $paymentMean
     *
     * @return Bill
     */
    public function setPaymentMean(\GS\BillBundle\Entity\paymentMeans $paymentMean = null)
    {
        $this->paymentMean = $paymentMean;

        return $this;
    }

    /**
     * Get paymentMean.
     *
     * @return \GS\BillBundle\Entity\paymentMeans|null
     */
    public function getPaymentMean()
    {
        return $this->paymentMean;
    }

    /**
     * Set followerMember.
     *
     * @param \GS\UserBundle\Entity\User|null $followerMember
     *
     * @return Bill
     */
    public function setFollowerMember(\GS\UserBundle\Entity\User $followerMember = null)
    {
        $this->followerMember = $followerMember;

        if($followerMember != null)
            $this->followerEmail = $followerMember->getEmail();
        else
            $this->followerEmail = null;

        return $this;
    }

    /**
     * Get followerMember.
     *
     * @return \GS\UserBundle\Entity\User|null
     */
    public function getFollowerMember()
    {
        return $this->followerMember;
    }

    /**
     * Set followerEmail.
     *
     * @param string|null $followerEmail
     *
     * @return Bill
     */
    public function setFollowerEmail($followerEmail = null)
    {
        if($this->followerMember == null)
            $this->followerEmail = $followerEmail;
        else
            $this->followerEmail = null;


        return $this;
    }

    /**
     * Get followerEmail.
     *
     * @return string|null
     */
    public function getFollowerEmail()
    {
        return $this->followerEmail;
    }

    /**
     * Set clientMember.
     *
     * @param \GS\UserBundle\Entity\User|null $clientMember
     *
     * @return Bill
     */
    public function setClientMember(\GS\UserBundle\Entity\User $clientMember = null)
    {
        $this->clientMember = $clientMember;

        return $this;
    }

    /**
     * Get clientMember.
     *
     * @return \GS\UserBundle\Entity\User|null
     */
    public function getClientMember()
    {
        return $this->clientMember;
    }

    /**
     * Set billType.
     *
     * @param \GS\BillBundle\Entity\BillType|null $billType
     *
     * @return Bill
     */
    public function setBillType(\GS\BillBundle\Entity\BillType $billType = null)
    {
        $this->billType = $billType;

        return $this;
    }

    /**
     * Get billType.
     *
     * @return \GS\BillBundle\Entity\BillType|null
     */
    public function getBillType()
    {
        return $this->billType;
    }

    /**
     * Set billPdf.
     *
     * @param string $billPdf
     *
     * @return Bill
     */
    public function setBillPdf($billPdf)
    {
        $this->billPdf = $billPdf;

        return $this;
    }

    /**
     * Get billPdf.
     *
     * @return string
     */
    public function getBillPdf()
    {
        return $this->billPdf;
    }
}
