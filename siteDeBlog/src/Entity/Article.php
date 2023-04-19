<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Commentaire::class)]
    private Collection $refCommentaireArticle;

    #[ORM\ManyToOne(inversedBy: 'refArticle')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: MotsCles::class, inversedBy: 'articles')]
    private Collection $possede;

    
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->refCommentaireArticle = new ArrayCollection();
        $this->possede = new ArrayCollection();
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

    /**
     * @return Collection<int, MotsCles>
     */
    public function getPossede(): Collection
    {
        return $this->possede;
    }

    public function addPossede(MotsCles $possede): self
    {
        if (!$this->possede->contains($possede)) {
            $this->possede->add($possede);
        }

        return $this;
    }

    public function removePossede(MotsCles $possede): self
    {
        $this->possede->removeElement($possede);

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

}
