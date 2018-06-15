<?php

namespace Geocaching\Exception;

class GeocachingApiException extends \Exception
{
    /**
     * GeocachingApiException constructor.
     *
     * @param string $message
     */
    public function __construct($message = 'Bad request exception', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
