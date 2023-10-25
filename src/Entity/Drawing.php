<?php

namespace App\Entity;

use App\Repository\DrawingRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Draw;


/**
 * @ORM\Entity(repositoryClass=DrawingRepository::class)
 */
class Drawing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Canvas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCanvas(): ?string
    {
        return $this->Canvas;
    }

    public function setCanvas(string $Canvas): self
    {
        $this->Canvas = $Canvas;

        return $this;
    }
}
