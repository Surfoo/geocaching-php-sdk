<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\GeocacheStatus;

class GeocacheStatusTest extends TestCase
{
    public function testGeocacheStatusCases(): void
    {
        $cases = GeocacheStatus::cases();
        
        $this->assertCount(5, $cases);
        $this->assertContains(GeocacheStatus::UNPUBLISHED, $cases);
        $this->assertContains(GeocacheStatus::ACTIVE, $cases);
        $this->assertContains(GeocacheStatus::DISABLED, $cases);
        $this->assertContains(GeocacheStatus::LOCKED, $cases);
        $this->assertContains(GeocacheStatus::ARCHIVED, $cases);
    }

    public function testGeocacheStatusValues(): void
    {
        $this->assertSame('Unpublished', GeocacheStatus::UNPUBLISHED->value);
        $this->assertSame('Active', GeocacheStatus::ACTIVE->value);
        $this->assertSame('Disabled', GeocacheStatus::DISABLED->value);
        $this->assertSame('Locked', GeocacheStatus::LOCKED->value);
        $this->assertSame('Archived', GeocacheStatus::ARCHIVED->value);
    }

    public function testGeocacheStatusIds(): void
    {
        $this->assertSame(1, GeocacheStatus::UNPUBLISHED->id());
        $this->assertSame(2, GeocacheStatus::ACTIVE->id());
        $this->assertSame(3, GeocacheStatus::DISABLED->id());
        $this->assertSame(4, GeocacheStatus::LOCKED->id());
        $this->assertSame(5, GeocacheStatus::ARCHIVED->id());
    }

    public function testGeocacheStatusFromId(): void
    {
        $this->assertSame(GeocacheStatus::UNPUBLISHED, GeocacheStatus::fromId(1));
        $this->assertSame(GeocacheStatus::ACTIVE, GeocacheStatus::fromId(2));
        $this->assertSame(GeocacheStatus::DISABLED, GeocacheStatus::fromId(3));
        $this->assertSame(GeocacheStatus::LOCKED, GeocacheStatus::fromId(4));
        $this->assertSame(GeocacheStatus::ARCHIVED, GeocacheStatus::fromId(5));
    }

    public function testGeocacheStatusFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        GeocacheStatus::fromId(999);
    }

    public function testGetList(): void
    {
        $list = GeocacheStatus::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(5, $list);
        $this->assertContains('Unpublished', $list);
        $this->assertContains('Active', $list);
        $this->assertContains('Disabled', $list);
        $this->assertContains('Locked', $list);
        $this->assertContains('Archived', $list);
    }

    public function testGetListId(): void
    {
        $listId = GeocacheStatus::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(5, $listId);
        $this->assertContains(1, $listId);
        $this->assertContains(2, $listId);
        $this->assertContains(3, $listId);
        $this->assertContains(4, $listId);
        $this->assertContains(5, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = GeocacheStatus::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All geocache status IDs should be unique');
    }

    public function testSpecificGeocacheStatuses(): void
    {
        // Test some specific important geocache statuses
        $this->assertSame('Active', GeocacheStatus::ACTIVE->value);
        $this->assertSame(2, GeocacheStatus::ACTIVE->id());
        
        $this->assertSame('Disabled', GeocacheStatus::DISABLED->value);
        $this->assertSame(3, GeocacheStatus::DISABLED->id());
        
        $this->assertSame('Archived', GeocacheStatus::ARCHIVED->value);
        $this->assertSame(5, GeocacheStatus::ARCHIVED->id());
    }
}