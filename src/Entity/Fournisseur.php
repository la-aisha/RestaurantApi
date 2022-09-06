<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\CreateMediaObjectAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
#[ApiResource(
    iri: 'https://schema.org/Fournisseur',
    normalizationContext: ['groups' => ['fournisseur:read']],
    denormalizationContext: ['groups' => ['fournisseur:write']],
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ],
    ],
)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id ;

    #[Groups(['fournisseur:write','fournisseur:read'])]
    #[ORM\Column(length: 255)]
    private ?string $nomFournisseur ;

    #[ApiProperty(iri: 'https://schema.org/contentUrl')]
    #[Groups(['fournisseur:read'])]
    public ?string $contentUrl ;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Groups(['fournisseur:write','fournisseur:read'])]
    public ?File $file ;

    #[Groups(['fournisseur:write','fournisseur:read'])]
    #[ORM\Column(nullable: true)] 
    public ?string $filePath ;

    #[Groups(['fournisseur:write','fournisseur:read'])]
    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'fournisseurs')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'fournisseurs', targetEntity: Element::class)]
    private Collection $elements;
    #[Groups(['fournisseur:write','fournisseur:read'])]
    #[ORM\ManyToOne(inversedBy: 'fournisseurs')]
    private ?Zone $zones ;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->elements = new ArrayCollection();
    }

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(string $nomFournisseur): self
    {
        $this->nomFournisseur = $nomFournisseur;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

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
            $element->setFournisseurs($this);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getFournisseurs() === $this) {
                $element->setFournisseurs(null);
            }
        }

        return $this;
    }

    public function getZones(): ?Zone
    {
        return $this->zones;
    }

    public function setZones(?Zone $zones): self
    {
        $this->zones = $zones;

        return $this;
    }

  
}
