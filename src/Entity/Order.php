<?php

namespace App\Entity;

use App\Interfaces\ValidatableInterface;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
#[UniqueEntity(fields: 'orderCode')]
#[ORM\HasLifecycleCallbacks()]
class Order implements ValidatableInterface, JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 12)]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 12)]
    private string $orderCode;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $quantity;

    #[ORM\Column(type: 'float')]
    private float $amount;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $address;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $shippingDate = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getOrderCode(): ?string
    {
        return strtoupper($this->orderCode);
    }

    /**
     * @param string $orderCode
     * @return $this
     */
    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = strtoupper($orderCode);

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return $this
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Order
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getShippingDate(): ?DateTime
    {
        return $this->shippingDate;
    }

    /**
     * @param DateTime|null $shippingDate
     * @return $this
     */
    public function setShippingDate(?DateTime $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Order
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function beforePersist()
    {
        $this->setUpdatedAt(new DateTime());
        $this->setCreatedAt(new DateTime());
    }

    #[ORM\PreUpdate]
    public function beforeUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'orderCode' => $this->getOrderCode(),
            'quantity' => $this->getQuantity(),
            'amount' => $this->getAmount(),
            'address' => $this->getAddress(),
            'shippingDate' => $this->getShippingDate()?->format('Y:m:d H:i'),
            'createdAt' => $this->getCreatedAt()->format('Y:m:d H:i'),
            'updatedAt' => $this->getUpdatedAt()->format('Y:m:d H:i'),
            'product' => $this->getProduct()->toArray(),
            'user' => $this->getUser()->toArray()
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
