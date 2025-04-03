<?php

declare(strict_types=1);

class Basket {
    public function __construct(
        private readonly array $catalogue,
        private readonly array $deliveryRules,
        private readonly array $offers = [],
        private array $items = [],
    ) {}
}