<?php

declare(strict_types=1);

namespace Tests\Enum;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\MembershipType;

class MembershipTypeTest extends TestCase
{
    public function testMembershipTypeCases(): void
    {
        $cases = MembershipType::cases();
        
        $this->assertCount(4, $cases);
        $this->assertContains(MembershipType::UNKNOWN, $cases);
        $this->assertContains(MembershipType::BASIC, $cases);
        $this->assertContains(MembershipType::CHARTER, $cases);
        $this->assertContains(MembershipType::PREMIUM, $cases);
    }

    public function testMembershipTypeValues(): void
    {
        $this->assertSame('Unknown', MembershipType::UNKNOWN->value);
        $this->assertSame('Basic', MembershipType::BASIC->value);
        $this->assertSame('Charter', MembershipType::CHARTER->value);
        $this->assertSame('Premium', MembershipType::PREMIUM->value);
    }

    public function testMembershipTypeIds(): void
    {
        $this->assertSame(0, MembershipType::UNKNOWN->id());
        $this->assertSame(1, MembershipType::BASIC->id());
        $this->assertSame(2, MembershipType::CHARTER->id());
        $this->assertSame(3, MembershipType::PREMIUM->id());
    }

    public function testMembershipTypeFromId(): void
    {
        $this->assertSame(MembershipType::UNKNOWN, MembershipType::fromId(0));
        $this->assertSame(MembershipType::BASIC, MembershipType::fromId(1));
        $this->assertSame(MembershipType::CHARTER, MembershipType::fromId(2));
        $this->assertSame(MembershipType::PREMIUM, MembershipType::fromId(3));
    }

    public function testMembershipTypeFromInvalidId(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Invalid Enum Id, given: 999');
        
        MembershipType::fromId(999);
    }

    public function testGetList(): void
    {
        $list = MembershipType::getList();
        
        $this->assertIsArray($list);
        $this->assertCount(4, $list);
        $this->assertContains('Unknown', $list);
        $this->assertContains('Basic', $list);
        $this->assertContains('Charter', $list);
        $this->assertContains('Premium', $list);
    }

    public function testGetListId(): void
    {
        $listId = MembershipType::getListId();
        
        $this->assertIsArray($listId);
        $this->assertCount(4, $listId);
        $this->assertContains(0, $listId);
        $this->assertContains(1, $listId);
        $this->assertContains(2, $listId);
        $this->assertContains(3, $listId);
    }

    public function testUniqueIds(): void
    {
        $ids = MembershipType::getListId();
        $uniqueIds = array_unique($ids);
        
        $this->assertCount(count($ids), $uniqueIds, 'All membership type IDs should be unique');
    }

    public function testSpecificMembershipTypes(): void
    {
        // Test some specific important membership types
        $this->assertSame('Premium', MembershipType::PREMIUM->value);
        $this->assertSame(3, MembershipType::PREMIUM->id());
        
        $this->assertSame('Charter', MembershipType::CHARTER->value);
        $this->assertSame(2, MembershipType::CHARTER->id());
        
        $this->assertSame('Basic', MembershipType::BASIC->value);
        $this->assertSame(1, MembershipType::BASIC->id());
    }
}