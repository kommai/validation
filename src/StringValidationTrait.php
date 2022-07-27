<?php

declare(strict_types=1);

namespace Kommai\Validation;

use InvalidArgumentException;

trait StringValidationTrait
{
    private function filled(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return strval($value) !== '';
            },
            'error' => $error,
        ];
        return $this;
    }

    private function equal(int|string $key, string $target, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($target) {
                return $value === $target;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function longer(int|string $key, int $length, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($length) {
                return mb_strlen((string) $value) > $length;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function shorter(int|string $key, int $length, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($length) {
                return mb_strlen((string) $value) < $length;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function email(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function url(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function regex(int|string $key, string $pattern, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($pattern) {
                $result = preg_match($pattern, $value);
                if ($result === false) {
                    throw new InvalidArgumentException('Invalid regular expression');
                }
                return $result === 1;
            },
            'error' => $error,
        ];
        return $this;
    }
}
