<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$values = [
    123,
    'ABC',
    'あいう',
];

foreach ($values as $value) {
    //var_dump(strlen((string) $value));
    var_dump(mb_strlen((string) $value));
}
