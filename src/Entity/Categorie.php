<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategorieRepository;
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
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource(
    iri: 'https://schema.org/Categorie',
    normalizationContext: ['groups' => ['categorie:read']],
    denormalizationContext: ['groups' => ['categorie:write']],
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ],
    ],
)]
class Categorie
{
    #[Groups(['categorie:write','categorie:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id ;

    #[Groups(['categorie:write','categorie:read'])]
    #[ORM\Column(length: 255)]
    private ?string $libelle ;
    
    #[Groups(['categorie:write','categorie:read'])]
    #[ORM\Column(length: 255)]
    private ?string $description ;

    #[ApiProperty(iri: 'https://schema.org/contentUrl')]
    #[Groups(['categorie:read'])]
    public ?string $contentUrl ;


    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Groups(['categorie:write','categorie:read'])]
    //#[ORM\Column(nullable: true)] 
    public ?File $file  ;

    #[Groups(['categorie:write','categorie:read'])]
    #[ORM\Column(nullable: true)] 
    public ?string $filePath ;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'categories')]
    private Collection $fournisseurs;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Element::class)]
    private Collection $elements;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
        $this->elements = new ArrayCollection();
    }

  

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->addCategory($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeCategory($this);
        }

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
            $element->setCategories($this);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getCategories() === $this) {
                $element->setCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }
    /**
     * @param File|null
     * @return Post
     */
    public function setFile(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

  
}
