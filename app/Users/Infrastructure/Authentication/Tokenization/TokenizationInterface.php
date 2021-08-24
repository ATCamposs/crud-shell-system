<?php

declare(strict_types=1);

Namespace app\Users\Infrastructure\Authentication\Tokenization;

interface TokenizationInterface
{
    public function encode(array $data): string;
    public function decode(string $token): ?array;
}