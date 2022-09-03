<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Domain\Model\VendingMachine;

class VendingMachine
{
    public function __construct(private readonly Maney $inputAmount = new Maney(0))
    {
    }

    public function canBuy(Button $button): bool
    {
        $beverage = Beverage::createByButton($button);

        return $beverage->canBuy($this->inputAmount);
    }

    public function push(Button $button): Beverage
    {
        if (!$this->canBuy($button)) throw new \DomainException('Input amount is insufficient.');

        return Beverage::createByButton($button);
    }

    public function insert(Maney $maney): self
    {
        if (!$maney->eq(new Maney(100))) throw new \DomainException('Only 100 yen can be inserted.');

        return new self($this->inputAmount->add($maney));
    }
}
