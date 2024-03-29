<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Closure;

// TODO: I don't think I need this when it has addRule()
trait CustomValidationTrait
{
    private function custom(int|string $key, Closure $callback, string $error): self
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
