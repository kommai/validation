<?php

declare(strict_types=1);

namespace Kommai\Validation;

use InvalidArgumentException;

class Validation
{
    protected array $rules = [];

    public function __invoke(array $data): array
    {
        $errors = [];
        foreach ($this->rules as $key => $rules) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentException(sprintf('The data is missing a value keyed "%s"', (string) $key));
            }
            foreach ($rules as $ruleset) {
                if (call_user_func($ruleset['validator'], $data[$key]) !== true) {
                    $errors[$key] = $ruleset['error'];
                    break;
                }
            }
        }
        return $errors;
    }
}
