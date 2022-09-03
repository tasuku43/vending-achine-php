<?php
declare(strict_types=1);

namespace Tasuku43\VendingMachine\Test\Domain\Model\VendingMachine;

use PHPUnit\Framework\TestCase;
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

    public function testCanBuy(): void
    {
        $machine = new VendingMachine();

        self::assertFalse($machine->canBuy(Button::Cola));
        self::assertFalse($machine->canBuy(Button::OolongTea));
        self::assertFalse($machine->canBuy(Button::RedBull));

        $machine = $machine->insert(new Maney(100));

        self::assertTrue($machine->canBuy(Button::Cola));
        self::assertTrue($machine->canBuy(Button::OolongTea));
        self::assertFalse($machine->canBuy(Button::RedBull));

        $machine = $machine->insert(new Maney(100));

        self::assertTrue($machine->canBuy(Button::RedBull));
    }

    public function testPush_お金をいれずにボタンを押すと例外が発生する(): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine->push(Button::Cola);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testInsert_10円、50円、500円のコインが使える(): void
    {
        $machine = new VendingMachine();

        $machine->insert(new Maney(10));
        $machine->insert(new Maney(50));
        $machine->insert(new Maney(100));
        $machine->insert(new Maney(500));
    }

    /**
     * @testWith [20]
     *           [30]
     *           [80]
     *           [120]
     *           [200]
     *           [1000]
     */
    public function testInsert_10円、50円、500円以外のコインは使えない(int $maney): void
    {
        $this->expectException(\DomainException::class);

        $machine = new VendingMachine();
        $machine->insert(new Maney($maney));
    }
}
