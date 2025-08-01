<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\GeocacheType;
use Geocaching\Enum\GeocacheLogType;
use Geocaching\Enum\Attribute;

class EnumTraitTest extends TestCase
{
    public function testFromIdReturnsCorrectEnum(): void
    {
        $geocacheType = GeocacheType::fromId(2);
        $this->assertSame(GeocacheType::TRADITIONAL, $geocacheType);

        $logType = GeocacheLogType::fromId(2);
        $this->assertSame(GeocacheLogType::FOUND_IT, $logType);

        $attribute = Attribute::fromId(1);
        $this->assertSame(Attribute::DOGS, $attribute);
    }

    public function testFromIdThrowsExceptionForInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999999');

        GeocacheType::fromId(999999);
    }

    public function testGetListReturnsAllValues(): void
    {
        $geocacheTypes = GeocacheType::getList();
        
        $this->assertIsArray($geocacheTypes);
        $this->assertContains('Traditional', $geocacheTypes);
        $this->assertContains('Multi-Cache', $geocacheTypes);
        $this->assertContains('Event', $geocacheTypes);
        $this->assertCount(19, $geocacheTypes);
    }

    public function testGetListIdReturnsAllIds(): void
    {
        $geocacheTypeIds = GeocacheType::getListId();
        
        $this->assertIsArray($geocacheTypeIds);
        $this->assertContains(2, $geocacheTypeIds);
        $this->assertContains(3, $geocacheTypeIds);
        $this->assertContains(6, $geocacheTypeIds);
        $this->assertCount(19, $geocacheTypeIds);
    }

    public function testGetListIdConsistencyWithFromId(): void
    {
        $allIds = GeocacheType::getListId();
        
        foreach ($allIds as $id) {
            $enum = GeocacheType::fromId($id);
            $this->assertSame($id, $enum->id());
        }
    }

    public function testGetListConsistencyWithCases(): void
    {
        $allValues = GeocacheType::getList();
        $allCases = GeocacheType::cases();
        
        $this->assertCount(count($allCases), $allValues);
        
        foreach ($allCases as $case) {
            $this->assertContains($case->value, $allValues);
        }
    }

    public function testAttributeEnumWithManyValues(): void
    {
        $attributes = Attribute::getList();
        $attributeIds = Attribute::getListId();
        
        $this->assertGreaterThan(70, count($attributes));
        $this->assertCount(count($attributes), $attributeIds);
        
        // Test some specific attributes
        $this->assertContains('Dogs', $attributes);
        $this->assertContains('Wheelchair accessible', $attributes);
        $this->assertContains('Challenge cache', $attributes);
    }

    public function testLogTypeEnum(): void
    {
        $logTypes = GeocacheLogType::getList();
        $logTypeIds = GeocacheLogType::getListId();
        
        $this->assertContains('Found It', $logTypes);
        $this->assertContains('Didn\'t find it', $logTypes);
        $this->assertContains('Will Attend', $logTypes);
        
        $this->assertContains(2, $logTypeIds); // Found It
        $this->assertContains(3, $logTypeIds); // Didn't find it
        $this->assertContains(9, $logTypeIds); // Will Attend
    }
}