<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Livre;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
* @UniqueEntity(
 *     fields={"nom_prenom"},
 *     errorPath="nom_prenom",
 *     message="Le nom et le prenom de l'auteur doit être unique."
 * )

 */
class Auteur
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
    private $nom_prenom;

    /**
     * @ORM\Column(type="string", length=1)
	 * @Assert\Regex("/^\M|F/",
     * message = "Le sexe est incorrect, il faut mettre M ou F."
     * )
     */
    private $sexe;

    /**
     * @ORM\Column(type="date") 
     */
    private $date_de_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite;

    /**
     * @ORM\ManyToMany(targetEntity=livre::class, inversedBy="auteur_livre")
     */
    private $livre_ecrit;

    public function __construct()
    {
        $this->livre_ecrit = new ArrayCollection();
    }

    public function getId(): ?int
    {http://localhost:8000/auteur/
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nom_prenom;
    }

    public function setNomPrenom(string $nom_prenom): self
    {
        $this->nom_prenom = $nom_prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this; 
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * @return Collection|livre[]
     */
    public function getLivreEcrit(): Collection
    {
        return $this->livre_ecrit;
    }

    public function addLivreEcrit(livre $livreEcrit): self
    {
        if (!$this->livre_ecrit->contains($livreEcrit)) {
            $this->livre_ecrit[] = $livreEcrit;
        }

        return $this;
    }

    public function removeLivreEcrit(livre $livreEcrit): self
    {
        $this->livre_ecrit->removeElement($livreEcrit);

        return $this;
    }
    public function __toString() { 
        return $this->nom_prenom; 
    }
     
}
