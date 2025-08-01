<?php

declare(strict_types=1);

namespace Tests\Enum;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\GeocacheType;

class GeocacheTypeTest extends TestCase
{
    public function testGeocacheTypeCases(): void
    {
        $cases = GeocacheType::cases();
        
        $this->assertCount(19, $cases);
        $this->assertContains(GeocacheType::TRADITIONAL, $cases);
        $this->assertContains(GeocacheType::MULTI_CACHE, $cases);
        $this->assertContains(GeocacheType::EVENT, $cases);
        $this->assertContains(GeocacheType::MYSTERY, $cases);
    }

    public function testGeocacheTypeValues(): void
    {
        $this->assertSame('Traditional', GeocacheType::TRADITIONAL->value);
        $this->assertSame('Multi-Cache', GeocacheType::MULTI_CACHE->value);
        $this->assertSame('Event', GeocacheType::EVENT->value);
        $this->assertSame('Mystery/Unknown', GeocacheType::MYSTERY->value);
        $this->assertSame('Giga-Event', GeocacheType::GIGA_EVENT->value);
    }

    public function testGeocacheTypeIds(): void
    {
        $this->assertSame(2, GeocacheType::TRADITIONAL->id());
        $this->assertSame(3, GeocacheType::MULTI_CACHE->id());
        $this->assertSame(6, GeocacheType::EVENT->id());
        $this->assertSame(8, GeocacheType::MYSTERY->id());
        $this->assertSame(137, GeocacheType::EARTHCACHE->id());
        $this->assertSame(7005, GeocacheType::GIGA_EVENT->id());
    }

    public function testGeocacheTypeFromId(): void
    {
        $this->assertSame(GeocacheType::TRADITIONAL, GeocacheType::fromId(2));
        $this->assertSame(GeocacheType::MULTI_CACHE, GeocacheType::fromId(3));
        $this->assertSame(GeocacheType::EVENT, GeocacheType::fromId(6));
        $this->assertSame(GeocacheType::MYSTERY, GeocacheType::fromId(8));
        $this->assertSame(GeocacheType::EARTHCACHE, GeocacheType::fromId(137));
    }

    public function testGeocacheTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        GeocacheType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = GeocacheType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(19, $list);
        $this->assertContains('Traditional', $list);
        $this->assertContains('Multi-Cache', $list);
        $this->assertContains('Event', $list);
        $this->assertContains('Giga-Event', $list);
    }

    public function testGetListId(): void
    {
        $listId = GeocacheType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(19, $listId);
        $this->assertContains(2, $listId);
        $this->assertContains(3, $listId);
        $this->assertContains(6, $listId);
        $this->assertContains(7005, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = GeocacheType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All geocache type IDs should be unique');
    }

    public function testSpecificGeocacheTypes(): void
    {
        // Test some specific important geocache types
        $this->assertSame('Project A.P.E.', GeocacheType::PROJECT_APE->value);
        $this->assertSame(9, GeocacheType::PROJECT_APE->id());
        
        $this->assertSame('Wherigo', GeocacheType::WHERIGO->value);
        $this->assertSame(1858, GeocacheType::WHERIGO->id());
        
        $this->assertSame('Cache In Trash Out Event', GeocacheType::CITO->value);
        $this->assertSame(13, GeocacheType::CITO->id());
    }
}