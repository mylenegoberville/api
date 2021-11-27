<?php

namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use App\Controller\UserProfilePictureController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 * @ORM\Table(name="`user`")
 */
#[ApiResource(
    attributes: [
        "normalization_context" =>[
            "enable_max_depth" => true,
            'groups' => ['user']
        ]
    ],
)]
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["user"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    #[Groups(["user"])]
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("order")
     */
    #[Groups(["user"])]
    private $lastName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("order")
     */
    #[Groups(["user"])]
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    #[Groups(["user"])]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     * @MaxDepth(1)
     */
    #[Groups(["user"])]
    private $orders;


    /**
     * @ORM\OneToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(["book", "editor", "order", "user"])]
    #[ApiProperty(iri: 'http://schema.org/image')]
    public $profilePicture;
    
    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(["user"])]
    private $UpdatedAt;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    #[Groups(["user"])]
    private $settings = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("order")
     */
    #[Groups(["user"])]
    private $phoneNumber;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="userInvoiceAddress", cascade={"persist", "remove"})
     * @Groups("order")
     */
    #[Groups(["user"])]
    private $invoiceAddress;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="userShippingAddress", cascade={"persist", "remove"})
     * @Groups("order")
     */
    #[Groups(["user"])]
    private $shippingAddress;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->baskets = new ArrayCollection();
        $this->UpdatedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getSettings(): ?array
    {
        return $this->settings;
    }

    public function setSettings(?array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getInvoiceAddress(): ?Address
    {
        return $this->invoiceAddress;
    }

    public function setInvoiceAddress(?Address $invoiceAddress): self
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    public function getShippingAddress(): ?Address
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?Address $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }
}
