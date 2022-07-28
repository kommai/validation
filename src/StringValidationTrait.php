<?php

declare(strict_types=1);

namespace Kommai\Validation;

use InvalidArgumentException;

trait StringValidationTrait
{
    private function filled(int|string $key, string $error): self
    {
        return $this->addRule($key, function ($value) {
            return (string) $value !== '';
        }, $error);
    }

    private function equal(int|string $key, string $target, string $error): self
    {
        return $this->addRule($key, function ($value) use ($target) {
            return (string) $value === $target;
        }, $error);
    }

    private function longer(int|string $key, int $length, string $error): self
    {
        return $this->addRule($key, function ($value) use ($length) {
            return mb_strlen((string) $value) > $length;
        }, $error);
    }

    private function shorter(int|string $key, int $length, string $error): self
    {
        return $this->addRule($key, function ($value) use ($length) {
            return mb_strlen((string) $value) < $length;
        }, $error);
    }

    private function email(int|string $key, string $error): self
    {
        return $this->addRule($key, function ($value) {
            return filter_var((string) $value, FILTER_VALIDATE_EMAIL) !== false;
        }, $error);
    }

    private function url(int|string $key, string $error): self
    {
        return $this->addRule($key, function ($value) {
            return filter_var((string) $value, FILTER_VALIDATE_URL) !== false;
        }, $error);
    }

    private function regex(int|string $key, string $pattern, string $error): self
    {
        return $this->addRule($key, function ($value) use ($pattern) {
            $result = preg_match($pattern, (string) $value);
            if ($result === false) {
                throw new InvalidArgumentException('Invalid regular expression');
            }
            return $result === 1;
        }, $error);
    }
}
