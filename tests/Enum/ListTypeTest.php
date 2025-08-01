<?php

declare(strict_types=1);

namespace Tests\Enum;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\ListType;

class ListTypeTest extends TestCase
{
    public function testListTypeCases(): void
    {
        $cases = ListType::cases();
        
        $this->assertCount(5, $cases);
        $this->assertContains(ListType::POCKET_QUERY, $cases);
        $this->assertContains(ListType::BOOKMARK, $cases);
        $this->assertContains(ListType::IGNORE, $cases);
        $this->assertContains(ListType::WATCH, $cases);
        $this->assertContains(ListType::FAVORITES, $cases);
    }

    public function testListTypeValues(): void
    {
        $this->assertSame('Pocket Query (pq)', ListType::POCKET_QUERY->value);
        $this->assertSame('Bookmark (bm)', ListType::BOOKMARK->value);
        $this->assertSame('Ignore (il)', ListType::IGNORE->value);
        $this->assertSame('Watch (wl)', ListType::WATCH->value);
        $this->assertSame('Favorites (fl)', ListType::FAVORITES->value);
    }

    public function testListTypeIds(): void
    {
        $this->assertSame(1, ListType::POCKET_QUERY->id());
        $this->assertSame(2, ListType::BOOKMARK->id());
        $this->assertSame(3, ListType::IGNORE->id());
        $this->assertSame(4, ListType::WATCH->id());
        $this->assertSame(5, ListType::FAVORITES->id());
    }

    public function testListTypeFromId(): void
    {
        $this->assertSame(ListType::POCKET_QUERY, ListType::fromId(1));
        $this->assertSame(ListType::BOOKMARK, ListType::fromId(2));
        $this->assertSame(ListType::IGNORE, ListType::fromId(3));
        $this->assertSame(ListType::WATCH, ListType::fromId(4));
        $this->assertSame(ListType::FAVORITES, ListType::fromId(5));
    }

    public function testListTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        ListType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = ListType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(5, $list);
        $this->assertContains('Pocket Query (pq)', $list);
        $this->assertContains('Bookmark (bm)', $list);
        $this->assertContains('Ignore (il)', $list);
        $this->assertContains('Watch (wl)', $list);
        $this->assertContains('Favorites (fl)', $list);
    }

    public function testGetListId(): void
    {
        $listId = ListType::getListId();
        
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
        $ids = ListType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All list type IDs should be unique');
    }

    public function testSpecificListTypes(): void
    {
        // Test some specific important list types
        $this->assertSame('Pocket Query (pq)', ListType::POCKET_QUERY->value);
        $this->assertSame(1, ListType::POCKET_QUERY->id());
        
        $this->assertSame('Favorites (fl)', ListType::FAVORITES->value);
        $this->assertSame(5, ListType::FAVORITES->id());
        
        $this->assertSame('Watch (wl)', ListType::WATCH->value);
        $this->assertSame(4, ListType::WATCH->id());
    }
}