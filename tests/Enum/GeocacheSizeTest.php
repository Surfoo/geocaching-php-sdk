<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\GeocacheSize;

class GeocacheSizeTest extends TestCase
{
    public function testGeocacheSizeCases(): void
    {
        $cases = GeocacheSize::cases();
        
        $this->assertCount(7, $cases);
        $this->assertContains(GeocacheSize::UNKNOWN, $cases);
        $this->assertContains(GeocacheSize::MICRO, $cases);
        $this->assertContains(GeocacheSize::SMALL, $cases);
        $this->assertContains(GeocacheSize::REGULAR, $cases);
        $this->assertContains(GeocacheSize::LARGE, $cases);
        $this->assertContains(GeocacheSize::VIRTUAL, $cases);
        $this->assertContains(GeocacheSize::OTHER, $cases);
    }

    public function testGeocacheSizeValues(): void
    {
        $this->assertSame('Unknown', GeocacheSize::UNKNOWN->value);
        $this->assertSame('Micro', GeocacheSize::MICRO->value);
        $this->assertSame('Regular', GeocacheSize::REGULAR->value);
        $this->assertSame('Large', GeocacheSize::LARGE->value);
        $this->assertSame('Virtual', GeocacheSize::VIRTUAL->value);
        $this->assertSame('Other', GeocacheSize::OTHER->value);
        $this->assertSame('Small', GeocacheSize::SMALL->value);
    }

    public function testGeocacheSizeIds(): void
    {
        $this->assertSame(1, GeocacheSize::UNKNOWN->id());
        $this->assertSame(2, GeocacheSize::MICRO->id());
        $this->assertSame(3, GeocacheSize::REGULAR->id());
        $this->assertSame(4, GeocacheSize::LARGE->id());
        $this->assertSame(5, GeocacheSize::VIRTUAL->id());
        $this->assertSame(6, GeocacheSize::OTHER->id());
        $this->assertSame(8, GeocacheSize::SMALL->id());
    }

    public function testGeocacheSizeFromId(): void
    {
        $this->assertSame(GeocacheSize::UNKNOWN, GeocacheSize::fromId(1));
        $this->assertSame(GeocacheSize::MICRO, GeocacheSize::fromId(2));
        $this->assertSame(GeocacheSize::REGULAR, GeocacheSize::fromId(3));
        $this->assertSame(GeocacheSize::LARGE, GeocacheSize::fromId(4));
        $this->assertSame(GeocacheSize::VIRTUAL, GeocacheSize::fromId(5));
        $this->assertSame(GeocacheSize::OTHER, GeocacheSize::fromId(6));
        $this->assertSame(GeocacheSize::SMALL, GeocacheSize::fromId(8));
    }

    public function testGeocacheSizeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        GeocacheSize::fromId(999);
    }

    public function testGetList(): void
    {
        $list = GeocacheSize::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(7, $list);
        $this->assertContains('Unknown', $list);
        $this->assertContains('Micro', $list);
        $this->assertContains('Small', $list);
        $this->assertContains('Regular', $list);
        $this->assertContains('Large', $list);
        $this->assertContains('Virtual', $list);
        $this->assertContains('Other', $list);
    }

    public function testGetListId(): void
    {
        $listId = GeocacheSize::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(7, $listId);
        $this->assertContains(1, $listId);
        $this->assertContains(2, $listId);
        $this->assertContains(3, $listId);
        $this->assertContains(4, $listId);
        $this->assertContains(5, $listId);
        $this->assertContains(6, $listId);
        $this->assertContains(8, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = GeocacheSize::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All geocache size IDs should be unique');
    }

    public function testSpecificGeocacheSizes(): void
    {
        // Test some specific important geocache sizes
        $this->assertSame('Micro', GeocacheSize::MICRO->value);
        $this->assertSame(2, GeocacheSize::MICRO->id());
        
        $this->assertSame('Small', GeocacheSize::SMALL->value);
        $this->assertSame(8, GeocacheSize::SMALL->id());
        
        $this->assertSame('Regular', GeocacheSize::REGULAR->value);
        $this->assertSame(3, GeocacheSize::REGULAR->id());
        
        $this->assertSame('Large', GeocacheSize::LARGE->value);
        $this->assertSame(4, GeocacheSize::LARGE->id());
    }

    public function testSizeOrdering(): void
    {
        // Test the general size ordering by IDs (micro=2, regular=3, large=4, small=8)
        $this->assertLessThan(GeocacheSize::REGULAR->id(), GeocacheSize::MICRO->id());
        $this->assertLessThan(GeocacheSize::LARGE->id(), GeocacheSize::REGULAR->id());
        $this->assertGreaterThan(GeocacheSize::LARGE->id(), GeocacheSize::SMALL->id());
    }
}