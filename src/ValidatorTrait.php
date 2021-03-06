<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Closure;
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

    public function custom(int|string $key, Closure $callback, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($callback) {
                return (bool) call_user_func($callback, $value);
            },
            'error' => $error,
        ];
        return $this;
    }
}
