<?php

namespace App\Utils;

use App\Entity\Order;

interface PriceProviderInterface
{
    public function getPrice(Order $order): float;
}