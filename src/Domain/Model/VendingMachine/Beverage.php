<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Domain\Model\VendingMachine;

class Beverage
{
    public function __construct(private readonly string $name, private readonly Maney $price)
    {
    }

    public static function createByButton(Button $button): self
    {
        return match ($button) {
            Button::Cola => new self('cola', new Maney(100)),
            Button::OolongTea => new self('oolong tea', new Maney(100)),
            Button::RedBull => new self('red bull', new Maney(200)),
        };
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function canBuy(Maney $inputAmount): bool
    {
        return $inputAmount->gt($this->price);
    }

    public function caluculateChange(Maney $inputAmount): Maney
    {
        assert($inputAmount->gt($this->price));

        return $inputAmount->sub($this->price);
    }
}
