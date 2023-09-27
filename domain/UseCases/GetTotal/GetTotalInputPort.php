<?php

namespace Domain\UseCases\GetTotal;

use Domain\Interfaces\ViewModel;

interface GetTotalInputPort
{
    public function getTotal(GetTotalRequestModel $request): ViewModel;
}
