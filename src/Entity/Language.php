<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tbl_language")
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=2)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    private $english_name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $native_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quiz", mappedBy="language")
     */
    private $quizzes;

    public function __construct()
    {
        $this->quizzes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEnglishName(): ?string
    {
        return $this->english_name;
    }

    public function setEnglishName(string $english_name): self
    {
        $this->english_name = $english_name;

        return $this;
    }

    public function getNativeName(): ?string
    {
        return $this->native_name;
    }

    public function setNativeName(string $native_name): self
    {
        $this->native_name = $native_name;

        return $this;
    }


    public function __toString(): ?string
    {
        return $this->getNativeName();
    }

    /**
     * @return Collection|Quiz[]
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setLanguage($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->contains($quiz)) {
            $this->quizzes->removeElement($quiz);
            // set the owning side to null (unless already changed)
            if ($quiz->getLanguage() === $this) {
                $quiz->setLanguage(null);
            }
        }

        return $this;
    }
}
