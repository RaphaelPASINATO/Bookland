<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Genre;
use App\Entity\Auteur;
/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=17)
       
     * @Assert\Regex(
     * pattern = "/^(97[8-9][-]([0-9]+)[-]([0-9]+)[-]([0-9]+)[-]([0-9]+))$/",
     * match ="false",
     * message ="Ce numéro de isbn n'est pas valide"
     * )
     
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbpages;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_parution;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "La note ne peut pas être négative !",
     *      maxMessage = "La note ne peut pas être supérieure à 20."
     * )
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, mappedBy="livre_ecrit")
     */
    private $auteur_livre;

    /**
     * @ORM\ManyToMany(targetEntity=genre::class, inversedBy="livres")
     */
    private $livre_genre;

    public function __construct()
    {
        $this->auteur_livre = new ArrayCollection();
        $this->livre_genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
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

    public function getNbpages(): ?int
    {
        return $this->nbpages;
    }

    public function setNbpages(int $nbpages): self
    {
        $this->nbpages = $nbpages;

        return $this;
    }

    public function getDateDeParution(): ?\DateTimeInterface
    {
        return $this->date_de_parution;
    }

    public function setDateDeParution(\DateTimeInterface $date_de_parution): self
    {
        $this->date_de_parution = $date_de_parution;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteurLivre(): Collection
    {
        return $this->auteur_livre;
    }

    public function addAuteurLivre(Auteur $auteurLivre): self
    {
        if (!$this->auteur_livre->contains($auteurLivre)) {
            $this->auteur_livre[] = $auteurLivre;
            $auteurLivre->addLivreEcrit($this);
        }

        return $this;
    }

    public function removeAuteurLivre(Auteur $auteurLivre): self
    {
        if ($this->auteur_livre->removeElement($auteurLivre)) {
            $auteurLivre->removeLivreEcrit($this);
        }

        return $this;
    }

    /**
     * @return Collection|genre[]
     */
    public function getLivreGenre(): Collection
    {
        return $this->livre_genre;
    }

    public function addLivreGenre(genre $livreGenre): self
    {
        if (!$this->livre_genre->contains($livreGenre)) {
            $this->livre_genre[] = $livreGenre;
        }

        return $this;
    }

    public function removeLivreGenre(genre $livreGenre): self
    {
        $this->livre_genre->removeElement($livreGenre);

        return $this;
    }

    public function __toString() { 
        return $this->titre; 
    }
}
