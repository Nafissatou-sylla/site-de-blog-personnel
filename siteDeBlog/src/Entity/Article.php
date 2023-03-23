<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptions = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Commentaire::class)]
    private Collection $refCommentaireArticle;

    #[ORM\ManyToOne(inversedBy: 'refArticle')]
    private ?User $user = null;

    public function __construct()
    {
        $this->refCommentaireArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getRefCommentaireArticle(): Collection
    {
        return $this->refCommentaireArticle;
    }

    public function addRefCommentaireArticle(Commentaire $refCommentaireArticle): self
    {
        if (!$this->refCommentaireArticle->contains($refCommentaireArticle)) {
            $this->refCommentaireArticle->add($refCommentaireArticle);
            $refCommentaireArticle->setArticle($this);
        }

        return $this;
    }

    public function removeRefCommentaireArticle(Commentaire $refCommentaireArticle): self
    {
        if ($this->refCommentaireArticle->removeElement($refCommentaireArticle)) {
            // set the owning side to null (unless already changed)
            if ($refCommentaireArticle->getArticle() === $this) {
                $refCommentaireArticle->setArticle(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
