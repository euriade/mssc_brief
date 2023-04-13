<?php

namespace App\Entity;

use App\Entity\Website;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: BriefRepository::class)]
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

    #[ORM\OneToMany(targetEntity: Website::class, mappedBy: 'brief')]
    #[ORM\JoinColumn(name: "website", referencedColumnName: "website", nullable: true)]
    protected $website;

    public function __construct()
    {
        $this->website = new ArrayCollection();
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domain = null;

    #[ORM\Column(nullable: true)]
    private ?bool $domain_suscribe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $domain_existing = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $host = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $host_login = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $host_password = null;

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

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $files_uploaded;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $more_information = null;

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

    public function getWebsite(): Collection
    {
        return $this->website;
    }

    public function addWebsite(Website $website): self
    {
        if (!$this->website->contains($website)) {
            $this->website[] = $website;
            $website->setBrief($this);
        }
        return $this;
    }

    public function removeWebsite(Website $website): self
    {
        if ($this->website->removeElement($website)) {
            if ($website->getBrief() === $this) {
                $website->setBrief(null);
            }
        }
        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function isDomainSuscribe(): ?bool
    {
        return $this->domain_suscribe;
    }

    public function setDomainSuscribe(?bool $domain_suscribe): self
    {
        $this->domain_suscribe = $domain_suscribe;

        return $this;
    }

    public function isDomainExisting(): ?bool
    {
        return $this->domain_existing;
    }

    public function setDomainExisting(?bool $domain_existing): self
    {
        $this->domain_existing = $domain_existing;

        return $this;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(?string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getHostLogin(): ?string
    {
        return $this->host_login;
    }

    public function setHostLogin(?string $host_login): self
    {
        $this->host_login = $host_login;

        return $this;
    }

    public function getHostPassword(): ?string
    {
        return $this->host_password;
    }

    public function setHostPassword(?string $host_password): self
    {
        $this->host_password = $host_password;

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

    public function getFilesUploaded(): ?string
    {
        return $this->files_uploaded;
    }

    public function setFilesUploaded(?string $files_uploaded): self
    {
        $this->files_uploaded = $files_uploaded;

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
}