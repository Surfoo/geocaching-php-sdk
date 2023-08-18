<?php

namespace Geocaching\Exception;

class UtilsException extends \Exception
{
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
