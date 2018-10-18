<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Lib\Utils\Utils;

final class UtilsTest extends TestCase
{

    public function providerReferenceCode()
    {
        return [
            ['GC1', 1],
            ['GC40', 64],
            ['GCG000', 65536],
            ['PR1QQQP', 1220432],
            ['GC728BR', 6121162],
            ['GC2SOSO', 1585032],
        ];
    }

    /**
     * @dataProvider providerReferenceCode
     */
    public function testReferenceCodeToIdSuccessful(string $referenceCode, int $expected): void
    {
        $result = Utils::referenceCodeToId($referenceCode);

        $this->assertEquals($expected, $result);
        $this->assertInternalType('int', $result);
    }

    public function providerReferenceCodeFail()
    {
        return [
            ['GCSRTOP']
        ];
    }

    /**
     * @dataProvider providerReferenceCodeFail
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Only chars 0123456789ABCDEFGHJKMNPQRTVWXYZ are supported.
     */
    public function testReferenceCodeToIdFail($referenceCode)
    {
        $result = Utils::referenceCodeToId($referenceCode);
    }

    public function providerId()
    {
        return [
            ['1', 'GC', 'GC1'],
            ['64', 'GC', 'GC40'],
            ['65536', 'GC', 'GCG000'],
            ['1220432', 'PR', 'PR1QQQP'],
            ['6121162', 'GC', 'GC728BR'],
            ['1585032', 'GC', 'GC25050'],
        ];
    }

    /**
     * @dataProvider providerId
     */
    public function testIdToReferenceCodeSucessful(string $number, string $prefix, string $expected): void
    {
        $result = Utils::idToReferenceCode($number, $prefix);

        $this->assertEquals($expected, $result);
        $this->assertInternalType('string', $result);
    }

}