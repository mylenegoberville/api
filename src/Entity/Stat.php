<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatRepository::class)
 */
#[ApiResource(
    itemOperations: [
        'order_last' => [
            'method' => 'GET',
            'path' => '/stats/stat',
            'controller' => OrderController::class,
        ],
        'order_stat' => [
            'method' => 'GET',
            'path' => '/stats/last',
            'controller' => OrderController::class,
        ]
    ],
    collectionOperations: [
    ]
)]
class Stat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
