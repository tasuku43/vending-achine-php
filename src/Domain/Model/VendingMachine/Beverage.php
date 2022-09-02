<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Domain\Model\VendingMachine;

class Beverage
{
    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
