<?php

declare(strict_types=1);

use Geocaching\Enum\AdditionalWaypointType;
use Geocaching\Enum\AdditionalWaypointVisibilityType;
use Geocaching\Enum\Attribute;
use Geocaching\Enum\GeocacheLogType;
use Geocaching\Enum\GeocacheLogUpvoteType;
use Geocaching\Enum\GeocacheSize;
use Geocaching\Enum\GeocacheStatus;
use Geocaching\Enum\GeocacheType;
use Geocaching\Enum\ListType;
use Geocaching\Enum\MembershipType;
use Geocaching\Enum\TrackableLogType;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function testEnumSuccessFul()
    {
        $this->assertEquals(0,   AdditionalWaypointVisibilityType::VISIBLE->id());
        $this->assertEquals(0,   MembershipType::UNKNOWN->id());
        $this->assertEquals(1,   Attribute::DOGS->id());
        $this->assertEquals(1,   GeocacheLogUpvoteType::GREAT_STORY->id());
        $this->assertEquals(1,   GeocacheSize::UNKNOWN->id());
        $this->assertEquals(1,   GeocacheStatus::UNPUBLISHED->id());
        $this->assertEquals(1,   ListType::POCKET_QUERY->id());
        $this->assertEquals(2,   GeocacheLogType::FOUND_IT->id());
        $this->assertEquals(2,   GeocacheType::TRADITIONAL->id());
        $this->assertEquals(217, AdditionalWaypointType::PARKING_AREA->id());
        $this->assertEquals(4,   TrackableLogType::WRITE_NOTE->id());
    }

    public function testEnumTraitSuccessFul()
    {
        $this->assertSame(Attribute::DOGS, Attribute::fromId(1));
    }

    public function testEnumTraitFail()
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: -1');

        Attribute::fromId(-1);
    }
}
