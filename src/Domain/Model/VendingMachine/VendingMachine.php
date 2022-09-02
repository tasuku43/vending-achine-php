<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Domain\Model\VendingMachine;

class VendingMachine
{
    public function pushButton(): Beverage
    {
        return new Beverage('cola');
    }
}
