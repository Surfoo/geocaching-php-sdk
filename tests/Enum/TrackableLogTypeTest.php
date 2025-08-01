<?php

declare(strict_types=1);

namespace Tests\Enum;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\TrackableLogType;

class TrackableLogTypeTest extends TestCase
{
    public function testTrackableLogTypeCases(): void
    {
        $cases = TrackableLogType::cases();
        
        $this->assertCount(10, $cases);
        $this->assertContains(TrackableLogType::WRITE_NOTE, $cases);
        $this->assertContains(TrackableLogType::RETRIEVE_IT, $cases);
        $this->assertContains(TrackableLogType::DROPPED_OFF, $cases);
        $this->assertContains(TrackableLogType::DISCOVERED_IT, $cases);
    }

    public function testTrackableLogTypeValues(): void
    {
        $this->assertSame('Write Note', TrackableLogType::WRITE_NOTE->value);
        $this->assertSame('Retrieve It from a Cache', TrackableLogType::RETRIEVE_IT->value);
        $this->assertSame('Dropped Off', TrackableLogType::DROPPED_OFF->value);
        $this->assertSame('Transfer', TrackableLogType::TRANSFER->value);
        $this->assertSame('Mark Missing', TrackableLogType::MARK_MISSING->value);
        $this->assertSame('Grab It (Not from a Cache)', TrackableLogType::GRAB_IT->value);
        $this->assertSame('Discovered It', TrackableLogType::DISCOVERED_IT->value);
        $this->assertSame('Move to Collection', TrackableLogType::MOVE_TO_COLLECTION->value);
        $this->assertSame('Move to Inventory', TrackableLogType::MOVE_TO_INVENTORY->value);
        $this->assertSame('Visited', TrackableLogType::VISITED->value);
    }

    public function testTrackableLogTypeIds(): void
    {
        $this->assertSame(4, TrackableLogType::WRITE_NOTE->id());
        $this->assertSame(13, TrackableLogType::RETRIEVE_IT->id());
        $this->assertSame(14, TrackableLogType::DROPPED_OFF->id());
        $this->assertSame(15, TrackableLogType::TRANSFER->id());
        $this->assertSame(16, TrackableLogType::MARK_MISSING->id());
        $this->assertSame(19, TrackableLogType::GRAB_IT->id());
        $this->assertSame(48, TrackableLogType::DISCOVERED_IT->id());
        $this->assertSame(69, TrackableLogType::MOVE_TO_COLLECTION->id());
        $this->assertSame(70, TrackableLogType::MOVE_TO_INVENTORY->id());
        $this->assertSame(75, TrackableLogType::VISITED->id());
    }

    public function testTrackableLogTypeFromId(): void
    {
        $this->assertSame(TrackableLogType::WRITE_NOTE, TrackableLogType::fromId(4));
        $this->assertSame(TrackableLogType::RETRIEVE_IT, TrackableLogType::fromId(13));
        $this->assertSame(TrackableLogType::DROPPED_OFF, TrackableLogType::fromId(14));
        $this->assertSame(TrackableLogType::TRANSFER, TrackableLogType::fromId(15));
        $this->assertSame(TrackableLogType::DISCOVERED_IT, TrackableLogType::fromId(48));
        $this->assertSame(TrackableLogType::VISITED, TrackableLogType::fromId(75));
    }

    public function testTrackableLogTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        TrackableLogType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = TrackableLogType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(10, $list);
        $this->assertContains('Write Note', $list);
        $this->assertContains('Retrieve It from a Cache', $list);
        $this->assertContains('Dropped Off', $list);
        $this->assertContains('Discovered It', $list);
        $this->assertContains('Visited', $list);
    }

    public function testGetListId(): void
    {
        $listId = TrackableLogType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(10, $listId);
        $this->assertContains(4, $listId);
        $this->assertContains(13, $listId);
        $this->assertContains(14, $listId);
        $this->assertContains(48, $listId);
        $this->assertContains(75, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = TrackableLogType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All trackable log type IDs should be unique');
    }

    public function testSpecificTrackableLogTypes(): void
    {
        // Test some specific important trackable log types
        $this->assertSame('Grab It (Not from a Cache)', TrackableLogType::GRAB_IT->value);
        $this->assertSame(19, TrackableLogType::GRAB_IT->id());
        
        $this->assertSame('Mark Missing', TrackableLogType::MARK_MISSING->value);
        $this->assertSame(16, TrackableLogType::MARK_MISSING->id());
        
        $this->assertSame('Move to Collection', TrackableLogType::MOVE_TO_COLLECTION->value);
        $this->assertSame(69, TrackableLogType::MOVE_TO_COLLECTION->id());
    }
}