<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogRepository::class)
 */
class Log
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reqMethod;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $reqUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $respCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $respBody;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getReqMethod(): ?string
    {
        return $this->reqMethod;
    }

    public function setReqMethod(?string $reqMethod): self
    {
        $this->reqMethod = $reqMethod;

        return $this;
    }

    public function getReqUrl(): ?string
    {
        return $this->reqUrl;
    }

    public function setReqUrl(?string $reqUrl): self
    {
        $this->reqUrl = $reqUrl;

        return $this;
    }

    public function getRespCode(): ?int
    {
        return $this->respCode;
    }

    public function setRespCode(?int $respCode): self
    {
        $this->respCode = $respCode;

        return $this;
    }

    public function getRespBody(): ?string
    {
        return $this->respBody;
    }

    public function setRespBody(?string $respBody): self
    {
        $this->respBody = $respBody;

        return $this;
    }
}
