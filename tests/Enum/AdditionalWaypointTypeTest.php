<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\AdditionalWaypointType;

class AdditionalWaypointTypeTest extends TestCase
{
    public function testAdditionalWaypointTypeCases(): void
    {
        $cases = AdditionalWaypointType::cases();
        
        $this->assertCount(6, $cases);
        $this->assertContains(AdditionalWaypointType::PARKING_AREA, $cases);
        $this->assertContains(AdditionalWaypointType::VIRTUAL_STAGE, $cases);
        $this->assertContains(AdditionalWaypointType::PHYSICAL_STAGE, $cases);
        $this->assertContains(AdditionalWaypointType::FINAL_LOCATION, $cases);
        $this->assertContains(AdditionalWaypointType::TRAILHEAD, $cases);
        $this->assertContains(AdditionalWaypointType::REFERENCE_POINT, $cases);
    }

    public function testAdditionalWaypointTypeValues(): void
    {
        $this->assertSame('Parking Area', AdditionalWaypointType::PARKING_AREA->value);
        $this->assertSame('Virtual Stage', AdditionalWaypointType::VIRTUAL_STAGE->value);
        $this->assertSame('Physical Stage', AdditionalWaypointType::PHYSICAL_STAGE->value);
        $this->assertSame('Final Location', AdditionalWaypointType::FINAL_LOCATION->value);
        $this->assertSame('Trailhead', AdditionalWaypointType::TRAILHEAD->value);
        $this->assertSame('Reference Point', AdditionalWaypointType::REFERENCE_POINT->value);
    }

    public function testAdditionalWaypointTypeIds(): void
    {
        $this->assertSame(217, AdditionalWaypointType::PARKING_AREA->id());
        $this->assertSame(218, AdditionalWaypointType::VIRTUAL_STAGE->id());
        $this->assertSame(219, AdditionalWaypointType::PHYSICAL_STAGE->id());
        $this->assertSame(220, AdditionalWaypointType::FINAL_LOCATION->id());
        $this->assertSame(221, AdditionalWaypointType::TRAILHEAD->id());
        $this->assertSame(452, AdditionalWaypointType::REFERENCE_POINT->id());
    }

    public function testAdditionalWaypointTypeFromId(): void
    {
        $this->assertSame(AdditionalWaypointType::PARKING_AREA, AdditionalWaypointType::fromId(217));
        $this->assertSame(AdditionalWaypointType::VIRTUAL_STAGE, AdditionalWaypointType::fromId(218));
        $this->assertSame(AdditionalWaypointType::PHYSICAL_STAGE, AdditionalWaypointType::fromId(219));
        $this->assertSame(AdditionalWaypointType::FINAL_LOCATION, AdditionalWaypointType::fromId(220));
        $this->assertSame(AdditionalWaypointType::TRAILHEAD, AdditionalWaypointType::fromId(221));
        $this->assertSame(AdditionalWaypointType::REFERENCE_POINT, AdditionalWaypointType::fromId(452));
    }

    public function testAdditionalWaypointTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        AdditionalWaypointType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = AdditionalWaypointType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(6, $list);
        $this->assertContains('Parking Area', $list);
        $this->assertContains('Virtual Stage', $list);
        $this->assertContains('Physical Stage', $list);
        $this->assertContains('Final Location', $list);
        $this->assertContains('Trailhead', $list);
        $this->assertContains('Reference Point', $list);
    }

    public function testGetListId(): void
    {
        $listId = AdditionalWaypointType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(6, $listId);
        $this->assertContains(217, $listId);
        $this->assertContains(218, $listId);
        $this->assertContains(219, $listId);
        $this->assertContains(220, $listId);
        $this->assertContains(221, $listId);
        $this->assertContains(452, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = AdditionalWaypointType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All additional waypoint type IDs should be unique');
    }

    public function testSpecificAdditionalWaypointTypes(): void
    {
        // Test some specific important additional waypoint types
        $this->assertSame('Parking Area', AdditionalWaypointType::PARKING_AREA->value);
        $this->assertSame(217, AdditionalWaypointType::PARKING_AREA->id());
        
        $this->assertSame('Final Location', AdditionalWaypointType::FINAL_LOCATION->value);
        $this->assertSame(220, AdditionalWaypointType::FINAL_LOCATION->id());
        
        $this->assertSame('Reference Point', AdditionalWaypointType::REFERENCE_POINT->value);
        $this->assertSame(452, AdditionalWaypointType::REFERENCE_POINT->id());
    }

    public function testStageTypes(): void
    {
        // Test stage-related waypoint types
        $this->assertSame('Virtual Stage', AdditionalWaypointType::VIRTUAL_STAGE->value);
        $this->assertSame(218, AdditionalWaypointType::VIRTUAL_STAGE->id());
        
        $this->assertSame('Physical Stage', AdditionalWaypointType::PHYSICAL_STAGE->value);
        $this->assertSame(219, AdditionalWaypointType::PHYSICAL_STAGE->id());
    }

    public function testConsecutiveIds(): void
    {
        // Test that the first 5 waypoint types have consecutive IDs
        $this->assertSame(218, AdditionalWaypointType::PARKING_AREA->id() + 1);
        $this->assertSame(219, AdditionalWaypointType::VIRTUAL_STAGE->id() + 1);
        $this->assertSame(220, AdditionalWaypointType::PHYSICAL_STAGE->id() + 1);
        $this->assertSame(221, AdditionalWaypointType::FINAL_LOCATION->id() + 1);
    }
}