<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\BookController;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
#[ApiResource(
    attributes: [
        "normalization_context" =>[
            "enable_max_depth" => true,
            'groups' => ['book']
        ]
    ],
    collectionOperations:[
        "get",
        "batch_delete"=>[
            "method" => "DELETE",
            "path" => "/books/batch_delete",
            "controller" => BookController::class
        ]
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'title' => 'partial',
    ]
)]
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["book", "editor", "drawer", "order"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "editor", "drawer", "order"])]
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "editor", "drawer", "order"])]
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Manga::class, inversedBy="books")
     * @MaxDepth(2)
     */
    #[Groups(["book", "editor", "drawer", "order"])]
    private $relatedManga;

    /**
     * @ORM\ManyToOne(targetEntity=Drawer::class, inversedBy="books")
     * @MaxDepth(1)
     */
    #[Groups(["book", "order"])]
    private $drawer;

    /**
     * @ORM\ManyToOne(targetEntity=Editor::class, inversedBy="books")
     * @MaxDepth(1)
     */
    #[Groups(["book", "order"])]
    private $editor;

    /**
     * @ORM\ManyToMany(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(["book", "editor", "drawer", "order"])]
    #[ApiProperty(iri: 'http://schema.org/image')]
    public $images;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(["book", "order"])]
    private $priceTaxExcl;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(["book", "order"])]
    private $priceTaxIncl;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(["book", "order"])]
    private $taxRate = 20;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(["book", "order"])]
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "editor", "drawer", "order"])]
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "order"])]
    private $width;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "order"])]
    private $height;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "order"])]
    private $depth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "order"])]
    private $weight;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(["book", "order"])]
    private $extraShippingFee;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(["book", "order"])]
    private $active = true;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRelatedManga(): ?Manga
    {
        return $this->relatedManga;
    }

    public function setRelatedManga(?Manga $relatedManga): self
    {
        $this->relatedManga = $relatedManga;

        return $this;
    }

    public function getDrawer(): ?Drawer
    {
        return $this->drawer;
    }

    public function setDrawer(?Drawer $drawer): self
    {
        $this->drawer = $drawer;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceTaxExcl(): ?float
    {
        return $this->priceTaxExcl;
    }

    public function setPriceTaxExcl(float $priceTaxExcl): self
    {
        $this->priceTaxExcl = $priceTaxExcl;

        return $this;
    }

    public function getPriceTaxIncl(): ?float
    {
        return $this->priceTaxIncl;
    }

    public function setPriceTaxIncl(float $priceTaxIncl): self
    {
        $this->priceTaxIncl = $priceTaxIncl;

        return $this;
    }

    public function getTaxRate(): ?int
    {
        return $this->taxRate;
    }

    public function setTaxRate(int $taxRate): self
    {
        $this->taxRate = $taxRate;

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

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDepth(): ?string
    {
        return $this->depth;
    }

    public function setDepth(string $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getExtraShippingFee(): ?float
    {
        return $this->extraShippingFee;
    }

    public function setExtraShippingFee(float $extraShippingFee): self
    {
        $this->extraShippingFee = $extraShippingFee;

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
}
