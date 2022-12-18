<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\CreateMediaObjectAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups; 
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['type:read']],
    denormalizationContext: ['groups' => ['type:write']],
    collectionOperations: [
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ],
    ],
)] 

class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['type:write','type:read','fournisseur:read'])]
    private ?int $id ;


    #[ORM\Column(length: 255)]
    #[Groups(['type:write','type:read','fournisseur:read'])]
    private ?string $type ;

    #[Groups(['type:read',])]
    public ?string $contentUrl ;


    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Groups(['type:write','type:read'])]
    //#[ORM\Column(nullable: true)] 
    public ?File $file= null ;

    #[Groups(['type:write','type:read'])]
    //#[ORM\Column(nullable: true)] 
    public ?string $filePath = null ;

    #[ORM\OneToMany(mappedBy: 'types', targetEntity: Fournisseur::class)]
    private Collection $fournisseurs;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $fournisseur->setTypes($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            // set the owning side to null (unless already changed)
            if ($fournisseur->getTypes() === $this) {
                $fournisseur->setTypes(null);
            }
        }

        return $this;
    }
}
