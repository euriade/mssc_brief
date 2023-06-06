<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Domain;
use App\Entity\Website;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BriefRepository::class)]
#[Vich\Uploadable]
class Brief
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customer_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customer_lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $online_date = null;

    #[ORM\OneToMany(targetEntity: Website::class, mappedBy: 'brief', cascade: ['persist', 'remove'])]
    private $websites;

    #[ORM\OneToMany(targetEntity: Domain::class, mappedBy: 'brief', cascade: ['persist', 'remove'])]
    private $domains;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artisan;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avocat;

    #[ORM\Column(nullable: true)]
    private ?bool $logo_reused = null;

    #[ORM\Column(nullable: true)]
    private ?bool $content_reused = null;

    #[ORM\Column(nullable: true)]
    private ?bool $other_data = null;

    #[ORM\OneToMany(mappedBy: 'brief', targetEntity: Attachment::class, cascade: ['persist', 'remove'])]
    private Collection $attachments;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $more_information = null;

    public function __construct()
    {
        $this->websites = new ArrayCollection();
        $this->domains = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'brief', cascade: ['persist'])]
    private ?User $createdBy;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'], nullable: true)]
    private ?\DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'brief', cascade: ['persist'])]
    private ?string $updatedBy;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customer_name): self
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getCustomerLastname(): ?string
    {
        return $this->customer_lastname;
    }

    public function setCustomerLastname(string $customer_lastname): self
    {
        $this->customer_lastname = $customer_lastname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function getOnlineDate(): ?\DateTimeInterface
    {
        return $this->online_date;
    }

    public function setOnlineDate(?\DateTimeInterface $online_date): self
    {
        $this->online_date = $online_date;

        return $this;
    }

    public function getWebsites(): Collection
    {
        return $this->websites;
    }

    public function addWebsite(Website $website): self
    {
        if (!$this->websites->contains($website)) {
            $this->websites[] = $website;
            $website->setBrief($this);
        }
        return $this;
    }

    public function removeWebsite(Website $website): self
    {
        if ($this->websites->removeElement($website)) {
            if ($website->getBrief() === $this) {
                $website->setBrief(null);
            }
        }
        return $this;
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain)) {
            $this->domains[] = $domain;
            $domain->setBrief($this);
        }
        return $this;
    }

    public function removeDomain(Domain $domain): self
    {
        if ($this->domains->removeElement($domain)) {
            if ($domain->getBrief() === $this) {
                $domain->setBrief(null);
            }
        }
        return $this;
    }

    public function getArtisan(): ?string
    {
        return $this->artisan;
    }

    public function setArtisan(?string $artisan): self
    {
        $this->artisan = $artisan;

        return $this;
    }

    public function getAvocat(): ?string
    {
        return $this->avocat;
    }

    public function setAvocat(?string $avocat): self
    {
        $this->avocat = $avocat;

        return $this;
    }

    public function isLogoReused(): ?bool
    {
        return $this->logo_reused;
    }

    public function setLogoReused(?bool $logo_reused): self
    {
        $this->logo_reused = $logo_reused;

        return $this;
    }

    public function isContentReused(): ?bool
    {
        return $this->content_reused;
    }

    public function setContentReused(?bool $content_reused): self
    {
        $this->content_reused = $content_reused;

        return $this;
    }

    public function isOtherData(): ?bool
    {
        return $this->other_data;
    }

    public function setOtherData(?bool $other_data): self
    {
        $this->other_data = $other_data;

        return $this;
    }

    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setBrief($this);
        }
        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            if ($attachment->getBrief() === $this) {
                $attachment->setBrief(null);
            }
        }
        return $this;
    }

    public function getMoreInformation(): ?string
    {
        return $this->more_information;
    }

    public function setMoreInformation(?string $more_information): self
    {
        $this->more_information = $more_information;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(User $user): self
    {
        $this->createdBy = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
