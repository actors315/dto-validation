<?php

require __DIR__ . '/../vendor/autoload.php';

$container = new \Twinkle\DI\Container([
    'Validate:Required' => \twinkle\dto\validation\annotation\Required::class,
    'Validate:Type' => \twinkle\dto\validation\annotation\Type::class,
    'Validate:Enum' => \twinkle\dto\validation\annotation\Enum::class,
]);
\Twinkle\DI\Tools::setContainer($container);