<?php

namespace App\Service;

use App\Service\Dto\AbstractDto;

abstract class AbstractService {
    abstract function execute(AbstractDto $dto): array;
}