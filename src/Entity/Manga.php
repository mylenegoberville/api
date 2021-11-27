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

/**
 * @ORM\Entity(repositoryClass=App\Repository\MangaRepository::class)
 */
#[ApiResource(
    attributes: [
        "normalization_context" =>[
            "enable_max_depth" => true,
            'groups' => ['manga']
        ]
    ],
    collectionOperations:[
        "get",
        "list" => [
            "method" => "get",
            "path" => '/mangas/list',
            "normalization_context" => ['groups' => ["manga:item"]]
        ]
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'title' => 'partial',
    ]
)]
class Manga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"manga", "manga:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"manga", "author", "genre", "book", "type", "book", "manga:item"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Groups("manga")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="mangas")
     * @Groups("manga")
     * @MaxDepth(1)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="relatedManga")
     * @Groups("manga")
     * @MaxDepth(1)
     */
    private $books;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, mappedBy="mangas")
     * @Groups({"manga", "book"})
     */
    private $genres;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="mangas")
     * @Groups({"manga", "book"})
     * @MaxDepth(1)
     */
    private $type;

    public function __construct()
    {
        $this->tomes = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->books = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

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
            $book->setRelatedManga($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getRelatedManga() === $this) {
                $book->setRelatedManga(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
            $genre->addManga($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeManga($this);
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
