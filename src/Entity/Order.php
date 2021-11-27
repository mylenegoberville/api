<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use App\Entity\OrderStatus;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
#[ApiResource(
    attributes: [
      "normalization_context" =>[
          "enable_max_depth" => true,
          'groups' => ['order']
      ]
  ],
)]
class Order
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
    private $reference;

    /**
     * @ORM\Column(type="float")
     * @Groups("order")
     */
    private $subTotal;

    /**
     * @ORM\Column(type="float")
     * @Groups("order")
     */
    private $tax = 20;

    /**
     * @ORM\Column(type="float")
     * @Groups("order")
     */
    private $discount;

    /**
     * @ORM\Column(type="float")
     * @Groups("order")
     */
    private $total;

    /**
     * @ORM\Column(type="date")
     * @Groups("order")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @Groups("order")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=OrderContent::class, mappedBy="aOrder")
     * @Groups("order")
     * @MaxDepth(2)
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=OrderStatus::class, mappedBy="statusOrder")
     * @Groups("order")
     */
    private $status;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups("order")
     */
    private $shippingDetails = [];

    /**
     * @ORM\Column(type="boolean")
     * @Groups("order")
     */
    private $active = true;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, mappedBy="paymentOrder", cascade={"persist", "remove"})
     * @Groups("order")
     */
    private $payment;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->products = new ArrayCollection();
        $this->status = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

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

    /**
     * @return Collection|OrderContent[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(OrderContent $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setAOrder($this);
        }

        return $this;
    }

    public function removeProduct(OrderContent $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAOrder() === $this) {
                $product->setAOrder(null);
            }
        }

        return $this;
    }

    public function getShippingDetails(): ?array
    {
        return $this->shippingDetails;
    }

    public function setShippingDetails(?array $shippingDetails): self
    {
        $this->shippingDetails = $shippingDetails;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getSubTotal(): ?float
    {
        return $this->subTotal;
    }

    public function setSubTotal(float $subTotal): self
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * @return Collection|OrderStatus[]
     */
    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function addStatus(OrderStatus $status): self
    {
        if (!$this->status->contains($status)) {
            $this->status[] = $status;
            $status->setStatusOrder($this);
        }

        return $this;
    }

    public function removeStatus(OrderStatus $status): self
    {
        if ($this->status->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getStatusOrder() === $this) {
                $status->setStatusOrder(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        // unset the owning side of the relation if necessary
        if ($payment === null && $this->payment !== null) {
            $this->payment->setPaymentOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($payment !== null && $payment->getPaymentOrder() !== $this) {
            $payment->setPaymentOrder($this);
        }

        $this->payment = $payment;

        return $this;
    }
}
