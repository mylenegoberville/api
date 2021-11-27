<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DrawerRepository;

/**
 * @ORM\Entity(repositoryClass=DrawerRepository::class)
 */
#[ApiResource(
    attributes: [
        "normalization_context" =>[
            "enable_max_depth" => true,
            'groups' => ['drawer']
        ]
    ],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: ["name" => "partial"]
)]
class Drawer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["drawer"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["book", "drawer"])]
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="drawer")
     * @MaxDepth(2)
     */
    #[Groups(["drawer"])]
    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setDrawer($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getDrawer() === $this) {
                $book->setDrawer(null);
            }
        }

        return $this;
    }
}
