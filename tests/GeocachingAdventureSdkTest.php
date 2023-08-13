<?php

declare(strict_types=1);

namespace Geocaching\Client\Tests;

// use Laminas\Diactoros\Response;

final class GeocachingAdventureSdkTest extends TestCase
{
    public function testGetAdventure(): void
    {
        $this->givenSdk()->getAdventure('12345678-ABCD-1234-EFGH-123456HIJKLM');
        $request = $this->mockClient->getRequests()[0];

        // $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/v1/adventures/12345678-ABCD-1234-EFGH-123456HIJKLM', $request->getUri()->getPath());
        // $this->assertCount(3, $request->getHeaders());
    }

    public function testSearchAdventures(): void
    {
        $this->givenSdk()->searchAdventures(['q' => 'location:[47,122]+radius:30mi']);
        $request = $this->mockClient->getRequests()[0];

        // $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/v1/adventures/search', $request->getUri()->getPath());
        $this->assertEquals('q=location%3A%5B47%2C122%5D%2Bradius%3A30mi', $request->getUri()->getQuery());
        // $this->assertCount(3, $request->getHeaders());
    }
}