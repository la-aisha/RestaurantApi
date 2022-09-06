<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ElementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\CreateMediaObjectAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
#[ApiResource(
    iri: 'https://schema.org/Element',
    normalizationContext: ['groups' => ['element:read']],
    denormalizationContext: ['groups' => ['element:write']],
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ],
    ],
)]
class Element
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id ;

    #[Groups(['element:write'])]
    #[ORM\Column(length: 255)]
    private ?string $nomEl ;


    #[Groups(['element:write','element:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $prix ;

    #[Groups(['element:write','element:read'])]
    #[ORM\Column(length: 255)]
    private ?string $descriptionEL ;

    #[Groups(['element:write','element:read'])]
    #[ORM\ManyToOne(inversedBy: 'elements')]
    private ?Categorie $categories ;

    #[Groups(['element:write','element:read'])]
    #[ORM\ManyToOne(inversedBy: 'elements')]
    private ?Fournisseur $fournisseurs ;

    #[ApiProperty(iri: 'https://schema.org/contentUrl')]
    #[Groups(['element:read'])]
    public ?string $contentUrl ;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Groups(['element:write','element:read'])]
    public ?File $file ;

    #[Groups(['element:write','element:read'])]
    #[ORM\Column(nullable: true)] 
    public ?string $filePath ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEl(): ?string
    {
        return $this->nomEl;
    }

    public function setNomEl(string $nomEl): self
    {
        $this->nomEl = $nomEl;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescriptionEL(): ?string
    {
        return $this->descriptionEL;
    }

    public function setDescriptionEL(string $descriptionEL): self
    {
        $this->descriptionEL = $descriptionEL;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getFournisseurs(): ?Fournisseur
    {
        return $this->fournisseurs;
    }

    public function setFournisseurs(?Fournisseur $fournisseurs): self
    {
        $this->fournisseurs = $fournisseurs;

        return $this;
    }
}
