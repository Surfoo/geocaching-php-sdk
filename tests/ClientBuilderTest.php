<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\ClientBuilder;
use Geocaching\Enum\BaseUri;

class ClientBuilderTest extends TestCase
{
    public function testGetBaseUriReturnsDefaultWhenNotSet(): void
    {
        $builder = new ClientBuilder();
        $this->assertEquals(BaseUri::PRODUCTION->value, $builder->getBaseUri());
    }

    public function testGetBaseUriReturnsCustomValue(): void
    {
        $builder = new ClientBuilder();
        $builder->setBaseUri('https://custom.example.com');
        $this->assertEquals('https://custom.example.com', $builder->getBaseUri());
    }
}
