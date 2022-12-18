<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(normalizationContext: ['groups' => ['commande']])]

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups('commande')]
    #[ORM\Column]
    private ?int $id ;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('commande')]

    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column]
    #[Groups('commande')]

    private ?bool $etat = null;

    #[ORM\Column]
    #[Groups('commande')]

    private ?int $prixC = null;

    #[ORM\Column(length: 255)]
    #[Groups('commande')]
    private ?string $paiementC = null;


    //#[ORM\Column(nullable: true)] 
    //#[Groups('commande')]
    //private ?int $prixTotal = null;

    //#[ORM\Column(nullable: true)] 
    //#[Groups('commande')]
    //private ?int $prixLivraison = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('commande')]
    #[ApiSubresource]
    private ?User $users = null;

    #[Groups('commande')]
    #[ORM\ManyToMany(targetEntity: Element::class, inversedBy: 'commandes')]
    private Collection $elements;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
    }

  
  

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPrixC(): ?int
    {
        return $this->prixC;
    }

    public function setPrixC(int $prixC): self
    {
        $this->prixC = $prixC;

        return $this;
    }

    public function getPaiementC(): ?string
    {
        return $this->paiementC;
    }

    public function setPaiementC(string $paiementC): self
    {
        $this->paiementC = $paiementC;

        return $this;
    }

    /* public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getPrixLivraison(): ?int
    {
        return $this->prixLivraison;
    }

    public function setPrixLivraison(int $prixLivraison): self
    {
        $this->prixLivraison = $prixLivraison;

        return $this;
    } */

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Element>
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function addElement(Element $element): self
    {
        if (!$this->elements->contains($element)) {
            $this->elements->add($element);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        $this->elements->removeElement($element);

        return $this;
    }

   

   
}
