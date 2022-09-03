<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Domain\Model\VendingMachine;

class VendingMachine
{
    public function __construct(private Maney $inputAmount = new Maney(0))
    {
    }

    public function canBuy(Button $button): bool
    {
        $beverage = Beverage::createByButton($button);

        return $beverage->canBuy($this->inputAmount);
    }

    /**
     * @param Button $button
     * @return array{Beverage, Maney}
     */
    public function push(Button $button): array
    {
        if (!$this->canBuy($button)) throw new \DomainException('Input amount is insufficient.');

        $beverage          = Beverage::createByButton($button);
        $inputAmmount      = $this->inputAmount->clone();
        $this->inputAmount = new Maney(0);

        return [$beverage, $beverage->caluculateChange($inputAmmount)];
    }

    public function insert(Maney $maney): self
    {
        if ($maney->eq(new Maney(10))
            || $maney->eq(new Maney(50))
            || $maney->eq(new Maney(100))
            || $maney->eq(new Maney(500))
        ) {
            $this->inputAmount = $this->inputAmount->add($maney);
            return $this;
        }

        throw new \DomainException('Only 100 yen can be inserted.');
    }
}
