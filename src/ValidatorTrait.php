<?php

declare(strict_types=1);

namespace Kommai\Validation;

trait ValidatorTrait
{
    private array $rules = [];

    public function validate(array $data)
    {
        // returns an array of errors
    }
}
