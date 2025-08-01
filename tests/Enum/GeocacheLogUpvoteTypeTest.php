<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\GeocacheLogUpvoteType;

class GeocacheLogUpvoteTypeTest extends TestCase
{
    public function testGeocacheLogUpvoteTypeCases(): void
    {
        $cases = GeocacheLogUpvoteType::cases();
        
        $this->assertCount(2, $cases);
        $this->assertContains(GeocacheLogUpvoteType::GREAT_STORY, $cases);
        $this->assertContains(GeocacheLogUpvoteType::HELPFUL, $cases);
    }

    public function testGeocacheLogUpvoteTypeValues(): void
    {
        $this->assertSame('GreatStory', GeocacheLogUpvoteType::GREAT_STORY->value);
        $this->assertSame('Helpful', GeocacheLogUpvoteType::HELPFUL->value);
    }

    public function testGeocacheLogUpvoteTypeIds(): void
    {
        $this->assertSame(1, GeocacheLogUpvoteType::GREAT_STORY->id());
        $this->assertSame(2, GeocacheLogUpvoteType::HELPFUL->id());
    }

    public function testGeocacheLogUpvoteTypeFromId(): void
    {
        $this->assertSame(GeocacheLogUpvoteType::GREAT_STORY, GeocacheLogUpvoteType::fromId(1));
        $this->assertSame(GeocacheLogUpvoteType::HELPFUL, GeocacheLogUpvoteType::fromId(2));
    }

    public function testGeocacheLogUpvoteTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        GeocacheLogUpvoteType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = GeocacheLogUpvoteType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(2, $list);
        $this->assertContains('GreatStory', $list);
        $this->assertContains('Helpful', $list);
    }

    public function testGetListId(): void
    {
        $listId = GeocacheLogUpvoteType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(2, $listId);
        $this->assertContains(1, $listId);
        $this->assertContains(2, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = GeocacheLogUpvoteType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All geocache log upvote type IDs should be unique');
    }

    public function testSpecificGeocacheLogUpvoteTypes(): void
    {
        // Test specific important geocache log upvote types
        $this->assertSame('GreatStory', GeocacheLogUpvoteType::GREAT_STORY->value);
        $this->assertSame(1, GeocacheLogUpvoteType::GREAT_STORY->id());
        
        $this->assertSame('Helpful', GeocacheLogUpvoteType::HELPFUL->value);
        $this->assertSame(2, GeocacheLogUpvoteType::HELPFUL->id());
    }
}