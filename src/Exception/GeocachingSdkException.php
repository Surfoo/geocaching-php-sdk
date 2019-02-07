<?php

namespace Geocaching\Exception;

class GeocachingSdkException extends \Exception
{
    protected $context = null;

    /**
     * @param string $message
     * @param int    $code
     * @param array  $context
     */
    public function __construct(string $message = 'Bad request exception', int $code = 0, array $context = [])
    {
        parent::__construct($message, $code);

        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }
}
