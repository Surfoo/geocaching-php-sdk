<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\Attribute;

class AttributeTest extends TestCase
{
    public function testAttributeCases(): void
    {
        $cases = Attribute::cases();
        
        $this->assertGreaterThan(70, count($cases));
        $this->assertContains(Attribute::DOGS, $cases);
        $this->assertContains(Attribute::WHEELCHAIR_ACCESSIBLE, $cases);
        $this->assertContains(Attribute::CHALLENGE_CACHE, $cases);
    }

    public function testAttributeValues(): void
    {
        $this->assertSame('Dogs', Attribute::DOGS->value);
        $this->assertSame('Access/parking fee', Attribute::ACCESS_PARKING_FEE->value);
        $this->assertSame('Wheelchair accessible', Attribute::WHEELCHAIR_ACCESSIBLE->value);
        $this->assertSame('Challenge cache', Attribute::CHALLENGE_CACHE->value);
        $this->assertSame('Geocaching.com solution checker', Attribute::GEOCACHING_SOLUTION_CHECKER->value);
    }

    public function testAttributeIds(): void
    {
        $this->assertSame(1, Attribute::DOGS->id());
        $this->assertSame(2, Attribute::ACCESS_PARKING_FEE->id());
        $this->assertSame(24, Attribute::WHEELCHAIR_ACCESSIBLE->id());
        $this->assertSame(71, Attribute::CHALLENGE_CACHE->id());
        $this->assertSame(72, Attribute::GEOCACHING_SOLUTION_CHECKER->id());
    }

    public function testAttributeFromId(): void
    {
        $this->assertSame(Attribute::DOGS, Attribute::fromId(1));
        $this->assertSame(Attribute::ACCESS_PARKING_FEE, Attribute::fromId(2));
        $this->assertSame(Attribute::WHEELCHAIR_ACCESSIBLE, Attribute::fromId(24));
        $this->assertSame(Attribute::CHALLENGE_CACHE, Attribute::fromId(71));
    }

    public function testAttributeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        Attribute::fromId(999);
    }

    public function testGetList(): void
    {
        $list = Attribute::getList();
        
        $this->assertIsArray($list);
        $this->assertGreaterThan(70, count($list));
        $this->assertContains('Dogs', $list);
        $this->assertContains('Wheelchair accessible', $list);
        $this->assertContains('Challenge cache', $list);
    }

    public function testGetListId(): void
    {
        $listId = Attribute::getListId();
        
        $this->assertIsArray($listId);
        $this->assertGreaterThan(70, count($listId));
        $this->assertContains(1, $listId);
        $this->assertContains(24, $listId);
        $this->assertContains(71, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = Attribute::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All attribute IDs should be unique');
    }

    public function testSpecificAttributes(): void
    {
        // Test some specific important attributes
        $this->assertSame('Recommended for kids', Attribute::RECOMMENDED_FOR_KIDS->value);
        $this->assertSame(6, Attribute::RECOMMENDED_FOR_KIDS->id());
        
        $this->assertSame('Available 24/7', Attribute::AVAILABLE_24_7->value);
        $this->assertSame(13, Attribute::AVAILABLE_24_7->id());
        
        $this->assertSame('Stealth required', Attribute::STEALTH_REQUIRED->value);
        $this->assertSame(40, Attribute::STEALTH_REQUIRED->id());
        
        $this->assertSame('Night cache', Attribute::NIGHT_CACHE->value);
        $this->assertSame(52, Attribute::NIGHT_CACHE->id());
    }

    public function testHikingAttributes(): void
    {
        $this->assertSame('Short hike (<1 km)', Attribute::SHORT_HIKE_1_KM->value);
        $this->assertSame(55, Attribute::SHORT_HIKE_1_KM->id());
        
        $this->assertSame('Medium hike (1 km–10 km)', Attribute::MEDIUM_HIKE_1_KM_10_KM->value);
        $this->assertSame(56, Attribute::MEDIUM_HIKE_1_KM_10_KM->id());
        
        $this->assertSame('Long hike (>10 km)', Attribute::LONG_HIKE_10_KM->value);
        $this->assertSame(57, Attribute::LONG_HIKE_10_KM->id());
    }

    public function testDangerousAttributes(): void
    {
        $this->assertSame('Dangerous animals', Attribute::DANGEROUS_ANIMALS->value);
        $this->assertSame(18, Attribute::DANGEROUS_ANIMALS->id());
        
        $this->assertSame('Cliff/falling rocks', Attribute::CLIFF_FALLING_ROCKS->value);
        $this->assertSame(21, Attribute::CLIFF_FALLING_ROCKS->id());
        
        $this->assertSame('Dangerous area', Attribute::DANGEROUS_AREA->value);
        $this->assertSame(23, Attribute::DANGEROUS_AREA->id());
    }

    public function testSpecialEquipmentAttributes(): void
    {
        $this->assertSame('Climbing gear required', Attribute::CLIMBING_GEAR_REQUIRED->value);
        $this->assertSame(3, Attribute::CLIMBING_GEAR_REQUIRED->id());
        
        $this->assertSame('UV light required', Attribute::UV_LIGHT_REQUIRED->value);
        $this->assertSame(48, Attribute::UV_LIGHT_REQUIRED->id());
        
        $this->assertSame('Special tool required', Attribute::SPECIAL_TOOL_REQUIRED->value);
        $this->assertSame(51, Attribute::SPECIAL_TOOL_REQUIRED->id());
    }
}