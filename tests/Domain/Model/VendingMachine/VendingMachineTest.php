<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Test\Domain\Model\VendingMachine;

use PHPUnit\Framework\TestCase;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\Beverage\Cola;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\Beverage\OolongTea;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\Button;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\Maney;
use Tasuku43\VendingMachine\Domain\Model\VendingMachine\VendingMachine;

class VendingMachineTest extends TestCase
{
    public function testPush_100円を投入してからコーラのボタンを押すとコーラが出てくる(): void
    {
        $machine = new VendingMachine();
        $machine = $machine->insert(new Maney(100));
        $beverage = $machine->push(Button::Cola);

        self::assertSame('cola', $beverage->getName());
    }

    public function testPush_100円を投入してからウーロン茶のボタンを押すとウーロン茶が出てくる(): void
    {
        $machine = new VendingMachine();
        $machine = $machine->insert(new Maney(100));
        $beverage = $machine->push(Button::OolongTea);

        self::assertSame('oolong tea', $beverage->getName());
    }

    public function testPush_200円を投入してからRedBullのボタンを押すとRedBullが出てくる(): void
    {
        $machine = new VendingMachine();
        $machine = $machine->insert(new Maney(100))->insert(new Maney(100));
        $beverage = $machine->push(Button::RedBull);

        self::assertSame('red bull', $beverage->getName());
    }

    public function testPush_100円を投入してからRedBullのボタンを押すと例外が発生する(): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine = $machine->insert(new Maney(100));
        $beverage = $machine->push(Button::RedBull);
    }

    public function testPush_お金をいれずにボタンを押すと例外が発生する(): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine->push(Button::Cola);
    }

    public function testInsert_100円以外を投入すると例外が発生する(): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine->insert(new Maney(1000));
    }
}
