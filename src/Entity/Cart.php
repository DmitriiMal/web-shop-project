<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_userID = null;


    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?bool $bought = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $order_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'carts')]
    private ?Product $fk_product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkUserID(): ?user
    {
        return $this->fk_userID;
    }

    public function setFkUserID(user $fk_userID): static
    {
        $this->fk_userID = $fk_userID;

        return $this;
    }


    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isBought(): ?bool
    {
        return $this->bought;
    }

    public function setBought(bool $bought): static
    {
        $this->bought = $bought;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeImmutable
    {
        return $this->order_date;
    }

    public function setOrderDate(\DateTimeImmutable $order_date): static
    {
        $this->order_date = $order_date;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFkProduct(): ?Product
    {
        return $this->fk_product;
    }

    public function setFkProduct(?Product $fk_product): static
    {
        $this->fk_product = $fk_product;

        return $this;
    }


}
