<?php

declare(strict_types=1);

namespace Kommai\Validation;

use RuntimeException;

trait RegexValidationTrait
{
    private function regex(int|string $key, string $pattern, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($pattern) {
                $result = preg_match($pattern, $value);
                if ($result === false) {
                    throw new RuntimeException('Failed to complete a match');
                }
                return $result === 1;
            },
            'error' => $error,
        ];
        return $this;
    }
}
