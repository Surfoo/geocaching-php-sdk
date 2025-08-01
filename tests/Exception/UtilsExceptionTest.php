<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Exception\UtilsException;

class UtilsExceptionTest extends TestCase
{
    public function testGetContextReturnsContextArray()
    {
        $context = ['foo' => 'bar', 'baz' => 42];
        $exception = new UtilsException('Test message', 123, $context);
        $this->assertSame($context, $exception->getContext());
    }

    public function testGetContextReturnsEmptyArrayByDefault()
    {
        $exception = new UtilsException('No context');
        $this->assertSame([], $exception->getContext());
    }
}
