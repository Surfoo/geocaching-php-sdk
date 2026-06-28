<?php

namespace Geocaching\Exception;

class UtilsException extends \Exception
{
    public function __construct(string $message, int $code = 0, private readonly array $context = [])
    {
        parent::__construct($message, $code);
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
