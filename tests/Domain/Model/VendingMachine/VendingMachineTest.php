<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Test\Domain\Model\VendingMachine;

use PHPUnit\Framework\TestCase;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\Maney;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\VendingMachine;

class VendingMachineTest extends TestCase
{
    public function testPushButton_100円を投入してからボタンを押すとコーラが出てくる(): void
    {
        $machine = new VendingMachine();
        $machine = $machine->insert(new Maney(100));
        $beverage = $machine->pushButton();

        self::assertSame('cola', $beverage->getName());
    }

    public function testPushButton_お金をいれずにボタンを押すと例外が発生する(): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine->pushButton();
    }

    public function testInsert_100円以外を投入すると例外が発生する(): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine->insert(new Maney(1000));
    }
}
