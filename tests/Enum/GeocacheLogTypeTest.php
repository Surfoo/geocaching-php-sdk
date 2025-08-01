<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\GeocacheLogType;

class GeocacheLogTypeTest extends TestCase
{
    public function testGeocacheLogTypeCases(): void
    {
        $cases = GeocacheLogType::cases();
        
        $this->assertCount(21, $cases);
        $this->assertContains(GeocacheLogType::FOUND_IT, $cases);
        $this->assertContains(GeocacheLogType::DID_NOT_FIND_IT, $cases);
        $this->assertContains(GeocacheLogType::WILL_ATTEND, $cases);
        $this->assertContains(GeocacheLogType::ATTENDED, $cases);
    }

    public function testGeocacheLogTypeValues(): void
    {
        $this->assertSame('Found It', GeocacheLogType::FOUND_IT->value);
        $this->assertSame('Didn\'t find it', GeocacheLogType::DID_NOT_FIND_IT->value);
        $this->assertSame('Write note', GeocacheLogType::WRITE_NOTE->value);
        $this->assertSame('Will Attend', GeocacheLogType::WILL_ATTEND->value);
        $this->assertSame('Attended', GeocacheLogType::ATTENDED->value);
    }

    public function testGeocacheLogTypeIds(): void
    {
        $this->assertSame(2, GeocacheLogType::FOUND_IT->id());
        $this->assertSame(3, GeocacheLogType::DID_NOT_FIND_IT->id());
        $this->assertSame(4, GeocacheLogType::WRITE_NOTE->id());
        $this->assertSame(9, GeocacheLogType::WILL_ATTEND->id());
        $this->assertSame(10, GeocacheLogType::ATTENDED->id());
        $this->assertSame(76, GeocacheLogType::SUBMIT_FOR_REVIEW->id());
    }

    public function testGeocacheLogTypeFromId(): void
    {
        $this->assertSame(GeocacheLogType::FOUND_IT, GeocacheLogType::fromId(2));
        $this->assertSame(GeocacheLogType::DID_NOT_FIND_IT, GeocacheLogType::fromId(3));
        $this->assertSame(GeocacheLogType::WRITE_NOTE, GeocacheLogType::fromId(4));
        $this->assertSame(GeocacheLogType::WILL_ATTEND, GeocacheLogType::fromId(9));
        $this->assertSame(GeocacheLogType::ATTENDED, GeocacheLogType::fromId(10));
    }

    public function testGeocacheLogTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        GeocacheLogType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = GeocacheLogType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(21, $list);
        $this->assertContains('Found It', $list);
        $this->assertContains('Didn\'t find it', $list);
        $this->assertContains('Will Attend', $list);
        $this->assertContains('Attended', $list);
    }

    public function testGetListId(): void
    {
        $listId = GeocacheLogType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(21, $listId);
        $this->assertContains(2, $listId);
        $this->assertContains(3, $listId);
        $this->assertContains(9, $listId);
        $this->assertContains(10, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = GeocacheLogType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All geocache log type IDs should be unique');
    }

    public function testSpecificLogTypes(): void
    {
        // Test some specific important log types
        $this->assertSame('Archive', GeocacheLogType::ARCHIVE->value);
        $this->assertSame(5, GeocacheLogType::ARCHIVE->id());
        
        $this->assertSame('Publish Listing', GeocacheLogType::PUBLISH_LISTING->value);
        $this->assertSame(24, GeocacheLogType::PUBLISH_LISTING->id());
        
        $this->assertSame('Needs Maintenance', GeocacheLogType::NEEDS_MAINTENANCE->value);
        $this->assertSame(45, GeocacheLogType::NEEDS_MAINTENANCE->id());
        
        $this->assertSame('Owner maintenance', GeocacheLogType::OWNER_MAINTENANCE->value);
        $this->assertSame(46, GeocacheLogType::OWNER_MAINTENANCE->id());
    }

    public function testDeprecatedLogType(): void
    {
        $this->assertSame('Post Reviewer Note (deprecated)', GeocacheLogType::POST_REVIEWER_NOTE_DEPRECATED->value);
        $this->assertSame(18, GeocacheLogType::POST_REVIEWER_NOTE_DEPRECATED->id());
    }
}