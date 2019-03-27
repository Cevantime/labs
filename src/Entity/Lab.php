<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LabRepository")
 */
class Lab
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $html;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $css;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $js;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $php;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="labs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasJquery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasFontawesome;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBootstrap;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived = false;

    /**
     * @param User|null $user
     * @return Lab
     */
    public function copy(User $user = null)
    {
        $copy = clone $this;
        $copy->name .= ' (copy)';
        if($user) {
            $copy->author = $user;
        }
        return $copy;
    }

    public function __clone()
    {
        $this->id = null;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(string $html): self
    {
        $this->html = $html;

        return $this;
    }

    public function getCss(): ?string
    {
        return $this->css;
    }

    public function setCss(?string $css): self
    {
        $this->css = $css;

        return $this;
    }

    public function getJs(): ?string
    {
        return $this->js;
    }

    public function setJs(?string $js): self
    {
        $this->js = $js;

        return $this;
    }

    public function getPhp(): ?string
    {
        return $this->php;
    }

    public function setPhp(?string $php): self
    {
        $this->php = $php;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getHasJquery(): ?bool
    {
        return $this->hasJquery;
    }

    public function setHasJquery(bool $hasJquery): self
    {
        $this->hasJquery = $hasJquery;

        return $this;
    }

    public function getHasFontawesome(): ?bool
    {
        return $this->hasFontawesome;
    }

    public function setHasFontawesome(bool $hasFontawesome): self
    {
        $this->hasFontawesome = $hasFontawesome;

        return $this;
    }

    public function getHasBootstrap(): ?bool
    {
        return $this->hasBootstrap;
    }

    public function setHasBootstrap(bool $hasBootstrap): self
    {
        $this->hasBootstrap = $hasBootstrap;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArchived():?bool
    {
        return $this->archived;
    }

    /**
     * @param mixed $archived
     * @return Lab
     */
    public function setArchived($archived): self
    {
        $this->archived = $archived;
        return $this;
    }
}
