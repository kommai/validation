<?php

declare(strict_types=1);

namespace Kommai\Validation;

use InvalidArgumentException;

class Validation
{
    protected array $rules = [];

    private static function validate(mixed $value, array $rules): ?string
    {
        foreach ($rules as $ruleset) {
            if (!call_user_func($ruleset['validator'], $value)) {
                return $ruleset['error'];
            }
        }
        return null;
    }

    public function __invoke(array $data): array
    {
        $errors = [];
        foreach ($data as $key => $value) {
            //echo sprintf('Validating "%s"...', $key), PHP_EOL;
            //var_dump($value);
            if (is_array($value)) {
                foreach ($value as $i => $item) {
                    $error = self::validate($item, $this->rules[$key]);
                    if (isset($error)) {
                        $errors[$key][$i] = $error;
                    }
                }
            } else {
                $error = self::validate($value, $this->rules[$key]);
                if (isset($error)) {
                    $errors[$key] = $error;
                }
            }
        }
        return $errors;
    }
}
