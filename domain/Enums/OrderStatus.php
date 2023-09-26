<?php

namespace Domain\Enums;

enum OrderStatus: int
{
    case CREATED = 0;
    case PAYMENT_CONFIRMED = 1;
    case PAYMENT_REJECTED = 2;
    case SHIPPED = 3;
}
