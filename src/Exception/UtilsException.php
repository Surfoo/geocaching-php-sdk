<?php

namespace Geocaching\Exception;

class UtilsException extends \Exception
{
    public function __construct(string $message, int $code = 0, protected ?array $context = [])
    {
        parent::__construct($message, $code);

        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
