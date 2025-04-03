<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Basket;
use App\Utils\Offers\RedWidgetOffer;
use App\Utils\DeliveryCalculators\StandardDeliveryCalculator;
use InvalidArgumentException;

class BasketTest extends TestCase
{
    private array $catalogue = [
        'R01' => 32.95,
        'G01' => 24.95,
        'B01' => 7.95,
    ];

    private array $deliveryRules = [
        50 => 4.95,
        90 => 2.95,
        PHP_INT_MAX => 0.00,
    ];

    private function basket(): Basket
    {
        return new Basket(
            $this->catalogue,
            new StandardDeliveryCalculator($this->deliveryRules),
            ['R01' => new RedWidgetOffer()]
        );
    }

    public function test_invalid_product_throws_exception(): void
    {
        $basket = $this->basket();

        $this->expectException(InvalidArgumentException::class);
        $basket->add('INVALID');
    }

    public function test_valid_products_are_accepted(): void
    {
        $basket = $this->basket();

        $this->expectNotToPerformAssertions();

        $basket->add('B01');
        $basket->add('G01');
        $basket->add('R01');
    }

    public function test_offer_applied_only_to_R01(): void
    {
        $basket = $this->basket();
        $basket->add('R01');
        $basket->add('R01');

        $expected = (32.95 + 16.475) + 4.95;
        $this->assertEquals(round($expected, 2), $basket->total());
    }

    public function test_delivery_charge_free_for_large_orders(): void
    {
        $basket = $this->basket();
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('B01');
        $basket->add('G01');
        $basket->add('G01');

        $subtotal = 32.95 + 16.475 + 7.95 + 24.95 + 24.95;
        $this->assertGreaterThanOrEqual(90, $subtotal);
        $this->assertEquals(round($subtotal, 2), $basket->total());
    }

    public function test_delivery_charge_tiers(): void
    {
        $basket = $this->basket();

        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());

        $basket = $this->basket();
        $basket->add('G01');
        $basket->add('G01');
        $basket->add('B01');
        $this->assertEquals(60.80, $basket->total());
    }
}
