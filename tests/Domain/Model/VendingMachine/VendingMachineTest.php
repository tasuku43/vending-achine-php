<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Test\Domain\Model\VendingMachine;

use Tasuku43\VendingMachine\Domain\Model\VendingMachine\VendingMachine;
use PHPUnit\Framework\TestCase;

class VendingMachineTest extends TestCase
{
    public function testPushButton_ボタンを押すとコーラが出てくる(): void
    {
        $machine = new VendingMachine();
        $beverage = $machine->pushButton();

        self::assertSame('cola', $beverage->getName());
    }
}
