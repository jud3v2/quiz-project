<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="products")
     */
    private int $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=true)
     */
    private string $question;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    /**
     * @return string|null
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param int $idCategorie
     */
    public function setIdCategorie(int $idCategorie): void
    {
        $this->idCategorie = $idCategorie;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }
}
