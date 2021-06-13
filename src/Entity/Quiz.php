<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=QCM::class)
     */
    private $qcms;

    public function __construct()
    {
        $this->qcms = new ArrayCollection();
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
     * @return Collection|QCM[]
     */
    public function getQcms(): Collection
    {
        return $this->qcms;
    }

    public function addQcm(QCM $qcm): self
    {
        if (!$this->qcms->contains($qcm)) {
            $this->qcms[] = $qcm;
        }

        return $this;
    }

    public function removeQcm(QCM $qcm): self
    {
        $this->qcms->removeElement($qcm);

        return $this;
    }
}
