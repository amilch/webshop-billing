<?php

namespace Domain\Services;

interface ReserveItemsService
{
    public function reserveItems(array $items): bool;

}
