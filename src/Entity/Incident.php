<?php

namespace App\Entity;

use App\Repository\IncidentRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncidentRepository::class)]
class Incident
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $reporterEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $processedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $resolveAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $rejectedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now',new \DateTimeZone('Europe/Paris'));
        $this->reference = $this->generateReference();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getReporterEmail(): ?string
    {
        return $this->reporterEmail;
    }

    public function setReporterEmail(string $reporterEmail): self
    {
        $this->reporterEmail = $reporterEmail;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getProcessedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }

    public function setProcessedAt(?\DateTimeImmutable $processedAt): self
    {
        $this->processedAt = $processedAt;

        return $this;
    }

    public function getResolveAt(): ?\DateTimeImmutable
    {
        return $this->resolveAt;
    }

    public function setResolveAt(?\DateTimeImmutable $resolveAt): self
    {
        $this->resolveAt = $resolveAt;

        return $this;
    }

    public function getRejectedAt(): ?\DateTimeImmutable
    {
        return $this->rejectedAt;
    }

    public function setRejectedAt(?\DateTimeImmutable $rejectedAt): self
    {
        $this->rejectedAt = $rejectedAt;

        return $this;
    }

    private function generateReference(): string
    {

        return implode("",[
            $this->createdAt->format("y"),
            $this->createdAt->format("m"),
            substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXYZ'),0,5)
        ]);

    }
}
