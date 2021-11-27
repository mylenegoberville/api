<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\GenreRepository::class)
 */
#[ApiResource(
    attributes: [
        "normalization_context" =>[
            "enable_max_depth" => true,
            'groups' => ['genre']
        ]
    ],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: ["name" => "partial"]
)]
class Genre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("genre")
     */
    #[Groups(["genre"])]
    private $id;


    /**
     * @var string Genre Name
     *
     * @ORM\Column
     * @Groups({"manga", "genre", "book"})
     */
    #[Groups(["manga", "genre"])]
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Manga::class, inversedBy="genres")
     * @Groups("genre")
     */
    private $mangas;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Manga[]
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        $this->mangas->removeElement($manga);

        return $this;
    }

}
