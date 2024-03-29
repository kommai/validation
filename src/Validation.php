<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Closure;

class Validation implements ValidationInterface
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

    protected function addRule(int|string $key, Closure $validator, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => $validator,
            'error' => $error
        ];
        return $this;
    }

    public function __invoke(array $data): array
    {
        $errors = [];
        foreach ($data as $key => $value) {
            //echo sprintf('Validating "%s"...', $key), PHP_EOL;
            //var_dump($value);
            if (!isset($this->rules[$key])) {
                //echo sprintf('No rules for "%s"', $key), PHP_EOL;
                continue;
            }
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
