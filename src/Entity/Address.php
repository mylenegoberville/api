<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="invoiceAddress")
     */
    private $userInvoiceAddress;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="shippingAddress")
     */
    private $userShippingAddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getUserInvoiceAddress(): ?User
    {
        return $this->userInvoiceAddress;
    }

    public function setUserInvoiceAddress(?User $userInvoiceAddress): self
    {
        // unset the owning side of the relation if necessary
        if ($userInvoiceAddress === null && $this->userInvoiceAddress !== null) {
            $this->userInvoiceAddress->setInvoiceAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($userInvoiceAddress !== null && $userInvoiceAddress->getInvoiceAddress() !== $this) {
            $userInvoiceAddress->setInvoiceAddress($this);
        }

        $this->userInvoiceAddress = $userInvoiceAddress;

        return $this;
    }

    public function getUserShippingAddress(): ?User
    {
        return $this->userShippingAddress;
    }

    public function setUserShippingAddress(?User $userShippingAddress): self
    {
        // unset the owning side of the relation if necessary
        if ($userShippingAddress === null && $this->userShippingAddress !== null) {
            $this->userShippingAddress->setShippingAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($userShippingAddress !== null && $userShippingAddress->getShippingAddress() !== $this) {
            $userShippingAddress->setShippingAddress($this);
        }

        $this->userShippingAddress = $userShippingAddress;

        return $this;
    }
}
