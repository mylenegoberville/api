<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=App\Repository\TypeRepository::class)
 */
#[ApiResource(
    attributes: [
        "normalization_context" =>[
            "enable_max_depth" => true,
            'groups' => ['type']
        ]
    ],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: ["name" => "partial"]
)]
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("type")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"manga", "type", "book"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Manga::class, mappedBy="type")
     * @Groups("type")
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
            $manga->setType($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->removeElement($manga)) {
            // set the owning side to null (unless already changed)
            if ($manga->getType() === $this) {
                $manga->setType(null);
            }
        }

        return $this;
    }
}
