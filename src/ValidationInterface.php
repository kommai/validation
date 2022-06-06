<?php

declare(strict_types=1);

namespace Kommai\Validation;

// who needs this?
interface ValidationInterface
{
    public function __invoke(array $data): array;
}
