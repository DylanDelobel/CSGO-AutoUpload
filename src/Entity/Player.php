<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $steam_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_csgo_match_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AuthToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSteamId(): ?string
    {
        return $this->steam_id;
    }

    public function setSteamId(string $steam_id): self
    {
        $this->steam_id = $steam_id;

        return $this;
    }

    public function getLastCsgoMatchCode(): ?string
    {
        return $this->last_csgo_match_code;
    }

    public function setLastCsgoMatchCode(string $last_csgo_match_code): self
    {
        $this->last_csgo_match_code = $last_csgo_match_code;

        return $this;
    }

    public function getAuthToken(): ?string
    {
        return $this->AuthToken;
    }

    public function setAuthToken(string $AuthToken): self
    {
        $this->AuthToken = $AuthToken;

        return $this;
    }
}
