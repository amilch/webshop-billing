<?php

namespace Domain\UseCases\GetTotal;

use Domain\Interfaces\ViewModel;

interface GetTotalOutputPort
{
    public function total(GetTotalResponseModel $model): ViewModel;
}
