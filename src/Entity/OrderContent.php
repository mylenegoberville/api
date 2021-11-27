<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderContentRepository;

/**
 * @ORM\Entity(repositoryClass=OrderContentRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => 'types',
            'normalization_context' => ['groups' => 'type:collection:list']
        ]
    ]
)]
class OrderContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("order")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="products")
     */
    private $aOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class)
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id",  onDelete="SET NULL")
     * @Groups("order")
     */
    private $book;

    /**
     * @ORM\Column(type="integer")
     * @Groups("order")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAOrder(): ?Order
    {
        return $this->aOrder;
    }

    public function setAOrder(?Order $aOrder): self
    {
        $this->aOrder = $aOrder;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
