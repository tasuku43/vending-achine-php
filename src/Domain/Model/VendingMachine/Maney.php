<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Domain\Model\VendingMachine;

class Maney
{
    public function __construct(private readonly int $value)
    {
    }

    public function eq(Maney $maney): bool
    {
        return $this->value === $maney->value;
    }

    public function gt(Maney $maney): bool
    {
        return $this->value >= $maney->value;
    }

    public function lt(Maney $maney): bool
    {
        return !$this->gt($maney);
    }

    public function add(Maney $maney): self
    {
        return new self($this->value + $maney->value);
    }
}