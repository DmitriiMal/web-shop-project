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

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: Product::class)]
    private Collection $fk_productID;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $order_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $price = null;

    public function __construct()
    {
        $this->fk_productID = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Product>
     */
    public function getFkProductID(): Collection
    {
        return $this->fk_productID;
    }

    public function addFkProductID(Product $fkProductID): static
    {
        if (!$this->fk_productID->contains($fkProductID)) {
            $this->fk_productID->add($fkProductID);
            $fkProductID->setCart($this);
        }

        return $this;
    }

    public function removeFkProductID(Product $fkProductID): static
    {
        if ($this->fk_productID->removeElement($fkProductID)) {
            // set the owning side to null (unless already changed)
            if ($fkProductID->getCart() === $this) {
                $fkProductID->setCart(null);
            }
        }

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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

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
}
