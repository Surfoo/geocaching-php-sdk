<?php

namespace Geocaching\Exception;

class GeocachingSdkException extends \Exception
{
    /**
     * @var array
     */
    protected $context = null;

    public function __construct(string $message = 'Bad request exception', int $code = 0, array $context = [])
    {
        parent::__construct($message, $code);

        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
