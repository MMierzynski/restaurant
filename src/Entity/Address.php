<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *     min="5",
     *     minMessage="Street name is to short, minimum 5 chars",
     *     max="50",
     *     maxMessage="Street name is to long, maximun 50 chars" )
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    private $houseNumber;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Regex(pattern="^\d{2}(?:[-\s]\d{3})?$^", message="Zip code is not valid")
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="boolean")
     */
    private $shipping;

    /**
     * @ORM\Column(type="boolean")
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getShipping(): ?bool
    {
        return $this->shipping;
    }

    public function setShipping(bool $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getInvoice(): ?bool
    {
        return $this->invoice;
    }

    public function setInvoice(bool $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
