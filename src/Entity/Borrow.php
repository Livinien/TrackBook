<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BorrowRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BorrowRepository::class)]
class Borrow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("post:read")]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'borrows')]
    #[Groups("post:read")]
    private ?User $idUser = null;

    #[ORM\OneToMany(mappedBy: 'idBorrow', targetEntity: Book::class)]
    #[Groups("post:read")]
    private Collection $books;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("post:read")]
    private ?\DateTimeInterface $dateBorrow = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("post:read")]
    private ?\DateTimeInterface $dateReturn = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setIdBorrow($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getIdBorrow() === $this) {
                $book->setIdBorrow(null);
            }
        }

        return $this;
    }

    public function getDateBorrow(): ?\DateTimeInterface
    {
        return $this->dateBorrow;
    }

    public function setDateBorrow(\DateTimeInterface $dateBorrow): self
    {
        $this->dateBorrow = $dateBorrow;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->dateReturn;
    }

    public function setDateReturn(\DateTimeInterface $dateReturn): self
    {
        $this->dateReturn = $dateReturn;

        return $this;
    }
}