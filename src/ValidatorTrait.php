<?php

declare(strict_types=1);

namespace Kommai\Validation;

use RuntimeException;

trait ValidatorTrait
{
    private array $rules = [];

    public function validate(array $data): array
    {
        $errors = [];
        foreach ($this->rules as $key => $rules) {
            if (!isset($data[$key])) {
                throw new RuntimeException(sprintf('The data is missing a value keyed "%s"', (string) $key));
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
