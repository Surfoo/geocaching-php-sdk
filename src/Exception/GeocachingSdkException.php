<?php

namespace Geocaching\Exception;

class GeocachingSdkException extends \Exception
{
    /**
     * GeocachingSdkException constructor.
     *
     * @param string $message
     */
    public function __construct($message = 'Bad request exception', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
