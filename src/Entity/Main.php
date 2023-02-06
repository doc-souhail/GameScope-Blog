<?php
// src/Entity/Main.php
namespace App\Entity;

use App\Repository\MainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: MainRepository::class)]
/**
 * @Vich\Uploadable
 */


class Main
{

    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $title;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $author;


    #[ORM\ManyToMany(targetEntity: ArticleKind::class, inversedBy: 'articles')]
    private $kinds;


    #[ORM\Column(type: 'string', nullable: true)]
    private $coverImageName;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id", nullable: false)]
    private $user;


    /**
     * @Vich\UploadableField(mapping="article_cover", fileNameProperty="coverImageName")
     */

    private $coverImageFile;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;



    #[ORM\Column(type: "text")]
    private $text;

    #[ORM\Column(type: "datetime")]
    private $posted;

    public function __construct()
    {
        $this->kinds = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getPosted()
    {
        return $this->posted;
    }

    /**
     * @param mixed $posted
     */
    public function setPosted($posted): self
    {
        $this->posted = $posted;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): self
    {
        $this->text = $text;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKinds()
    {
        return $this->kinds;

    }

    /**
     * @param mixed $kinds
     */
    public function setKinds($kinds): self
    {
        $this->kinds = $kinds;
        return $this;
    }


    public function addKinds(ArticleKind $articleKind)
    {
        // Vérifie qu'un genre ne soit pas déjà attribué avant de l'ajouter
        if (!$this->kinds->contains($articleKind)) {
            $this->kinds->add($articleKind);
        }
    }

    public function removeKinds(ArticleKind $articleKind)
    {
        // Vérifie que le livre a le genre qu'on souhaite enlever
        if ($this->kinds->contains($articleKind)) {
            $this->kinds->remove($articleKind);
        }
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $coverImageFile
     */

    public function setCoverImageFile(?File $coverImageFile = null): self
    {
        $this->coverImageFile = $coverImageFile;

        if (null !== $coverImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getCoverImageFile(): ?File
    {
        return $this->coverImageFile;
    }

    public function setCoverImageName(?string $coverImageName): self
    {
        $this->coverImageName = $coverImageName;
        return $this;
    }

    public function getCoverImageName(): ?string
    {
        return $this->coverImageName;

    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): self
    {
        $this->user = $user;
        return $this;
    }

}
