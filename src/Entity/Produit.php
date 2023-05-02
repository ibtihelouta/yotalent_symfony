<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Serializer\Annotation\Groups ;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column] 
    #[Groups("produits")]
    private ?int $id = null;




    #[ORM\Column]
    #[Assert\Positive(message:"La reference doit etre positive")]
    #[Assert\NotBlank(message:"Referennce est vide")]
    #[Groups("produits")]
    private ?int $idP = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom est vide")]
    #[Groups("produits")]
    private ?string $nomP = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Le prix doit etre positive")]
    #[Assert\NotBlank(message:"Prix est invalide")]
    #[Groups("produits")]
    private ?float $prixP = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Description est vide")]
    #[Groups("produits")]
    private ?string $descriptionP = null;

    #[ORM\Column(length: 255)]
    
    #[Groups("produits")]
    private ?string $imgP = null;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    private ?Commande $idCommande = null;
  
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdP(): ?int
    {
        return $this->idP;
    }

    public function setIdP(int $idP): self
    {
        $this->idP = $idP;

        return $this;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): self
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getPrixP(): ?float
    {
        return $this->prixP;
    }

    public function setPrixP(float $prixP): self
    {
        $this->prixP = $prixP;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->descriptionP;
    }

    public function setDescriptionP(string $descriptionP): self
    {
        $this->descriptionP = $descriptionP;

        return $this;
    }


    
    public function getImgP(): ?string
    {
        return $this->imgP;
    }

    public function setImgP(string $imgP): self
    {
        $this->imgP = $imgP;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(?Commande $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }
    public function __toString():string
{
 return $this->nomP;  
}
}
