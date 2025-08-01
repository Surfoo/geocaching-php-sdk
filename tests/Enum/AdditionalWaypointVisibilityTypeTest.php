<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\AdditionalWaypointVisibilityType;

class AdditionalWaypointVisibilityTypeTest extends TestCase
{
    public function testAdditionalWaypointVisibilityTypeCases(): void
    {
        $cases = AdditionalWaypointVisibilityType::cases();
        
        $this->assertCount(3, $cases);
        $this->assertContains(AdditionalWaypointVisibilityType::VISIBLE, $cases);
        $this->assertContains(AdditionalWaypointVisibilityType::HIDE_COORDINATES, $cases);
        $this->assertContains(AdditionalWaypointVisibilityType::HIDDEN, $cases);
    }

    public function testAdditionalWaypointVisibilityTypeValues(): void
    {
        $this->assertSame('Visible', AdditionalWaypointVisibilityType::VISIBLE->value);
        $this->assertSame('Hide Coordinates', AdditionalWaypointVisibilityType::HIDE_COORDINATES->value);
        $this->assertSame('Hidden', AdditionalWaypointVisibilityType::HIDDEN->value);
    }

    public function testAdditionalWaypointVisibilityTypeIds(): void
    {
        $this->assertSame(0, AdditionalWaypointVisibilityType::VISIBLE->id());
        $this->assertSame(1, AdditionalWaypointVisibilityType::HIDE_COORDINATES->id());
        $this->assertSame(2, AdditionalWaypointVisibilityType::HIDDEN->id());
    }

    public function testAdditionalWaypointVisibilityTypeFromId(): void
    {
        $this->assertSame(AdditionalWaypointVisibilityType::VISIBLE, AdditionalWaypointVisibilityType::fromId(0));
        $this->assertSame(AdditionalWaypointVisibilityType::HIDE_COORDINATES, AdditionalWaypointVisibilityType::fromId(1));
        $this->assertSame(AdditionalWaypointVisibilityType::HIDDEN, AdditionalWaypointVisibilityType::fromId(2));
    }

    public function testAdditionalWaypointVisibilityTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        AdditionalWaypointVisibilityType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = AdditionalWaypointVisibilityType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(3, $list);
        $this->assertContains('Visible', $list);
        $this->assertContains('Hide Coordinates', $list);
        $this->assertContains('Hidden', $list);
    }

    public function testGetListId(): void
    {
        $listId = AdditionalWaypointVisibilityType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(3, $listId);
        $this->assertContains(0, $listId);
        $this->assertContains(1, $listId);
        $this->assertContains(2, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = AdditionalWaypointVisibilityType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All additional waypoint visibility type IDs should be unique');
    }

    public function testSpecificAdditionalWaypointVisibilityTypes(): void
    {
        // Test specific important additional waypoint visibility types
        $this->assertSame('Visible', AdditionalWaypointVisibilityType::VISIBLE->value);
        $this->assertSame(0, AdditionalWaypointVisibilityType::VISIBLE->id());
        
        $this->assertSame('Hide Coordinates', AdditionalWaypointVisibilityType::HIDE_COORDINATES->value);
        $this->assertSame(1, AdditionalWaypointVisibilityType::HIDE_COORDINATES->id());
        
        $this->assertSame('Hidden', AdditionalWaypointVisibilityType::HIDDEN->value);
        $this->assertSame(2, AdditionalWaypointVisibilityType::HIDDEN->id());
    }

    public function testVisibilityOrdering(): void
    {
        // Test the visibility level ordering by IDs (0 = most visible, 2 = least visible)
        $this->assertGreaterThan(AdditionalWaypointVisibilityType::VISIBLE->id(), AdditionalWaypointVisibilityType::HIDE_COORDINATES->id());
        $this->assertGreaterThan(AdditionalWaypointVisibilityType::HIDE_COORDINATES->id(), AdditionalWaypointVisibilityType::HIDDEN->id());
    }
}