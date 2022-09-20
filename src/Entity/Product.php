<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $p_bar_code = null;

    #[ORM\Column(length: 128)]
    private ?string $p_name = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $p_brand = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Favorite::class, orphanRemoval: true)]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: HomeProduct::class, orphanRemoval: true)]
    private Collection $homeProducts;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->homeProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPBarCode(): ?string
    {
        return $this->p_bar_code;
    }

    public function setPBarCode(string $p_bar_code): self
    {
        $this->p_bar_code = $p_bar_code;

        return $this;
    }

    public function getPName(): ?string
    {
        return $this->p_name;
    }

    public function setPName(string $p_name): self
    {
        $this->p_name = $p_name;

        return $this;
    }

    public function getPBrand(): ?string
    {
        return $this->p_brand;
    }

    public function setPBrand(?string $p_brand): self
    {
        $this->p_brand = $p_brand;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setProduct($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getProduct() === $this) {
                $favorite->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HomeProduct>
     */
    public function getHomeProducts(): Collection
    {
        return $this->homeProducts;
    }

    public function addHomeProduct(HomeProduct $homeProduct): self
    {
        if (!$this->homeProducts->contains($homeProduct)) {
            $this->homeProducts->add($homeProduct);
            $homeProduct->setProduct($this);
        }

        return $this;
    }

    public function removeHomeProduct(HomeProduct $homeProduct): self
    {
        if ($this->homeProducts->removeElement($homeProduct)) {
            // set the owning side to null (unless already changed)
            if ($homeProduct->getProduct() === $this) {
                $homeProduct->setProduct(null);
            }
        }

        return $this;
    }
}
