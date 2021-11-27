<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\PaymentRepository;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("order")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    private $transactionId;

    /**
     * @ORM\Column(type="float")
     * @Groups("order")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    private $method;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("order")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="payment", cascade={"persist", "remove"})
     */
    private $paymentOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPaymentOrder(): ?Order
    {
        return $this->paymentOrder;
    }

    public function setPaymentOrder(?Order $paymentOrder): self
    {
        $this->paymentOrder = $paymentOrder;

        return $this;
    }
}
