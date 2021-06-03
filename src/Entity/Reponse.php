<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity
 */
class Reponse
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
     * @ORM\Column(name="id_question", type="integer", nullable=true)
     */
    private int $idQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable=true)
     */
    private string $reponse;

    /**
     * @var bool
     *
     * @ORM\Column(name="reponse_expected", type="boolean", nullable=true)
     */
    private bool $reponseExpected;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function getReponseExpected(): bool
    {
        return $this->reponseExpected;
    }

    /**
     * @param bool $reponseExpected
     */
    public function setReponseExpected(bool $reponseExpected): void
    {
        $this->reponseExpected = $reponseExpected;
    }

    /**
     * @return string
     */
    public function getReponse(): string
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     */
    public function setReponse(string $reponse): void
    {
        $this->reponse = $reponse;
    }

    /**
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * @param int|null $idQuestion
     */
    public function setIdQuestion(?int $idQuestion): void
    {
        $this->idQuestion = $idQuestion;
    }


}
