<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\OrderStatusRepository;

/**
 * @ORM\Entity(repositoryClass=OrderStatusRepository::class)
 */
class OrderStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("order")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("order")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="status")
     */
    private $statusOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @Groups("order")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatusOrder(): ?Order
    {
        return $this->statusOrder;
    }

    public function setStatusOrder(?Order $statusOrder): self
    {
        $this->statusOrder = $statusOrder;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }
}
