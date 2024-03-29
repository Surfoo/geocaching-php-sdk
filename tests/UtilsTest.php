<?php

declare(strict_types=1);

use Geocaching\Utils;
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase
{
    public static function providerDecimalToDegreeDecimal()
    {
        return [
            [0, 0,                  'N 00° 0.000 E 000° 0.000'],
            [48.855600, 2.365517,   'N 48° 51.336 E 002° 21.931'],
            [-48.855600, 2.365517,  'S 48° 51.336 E 002° 21.931'],
            [48.855600, -2.365517,  'N 48° 51.336 W 002° 21.931'],
            [-48.855600, -2.365517, 'S 48° 51.336 W 002° 21.931'],
        ];
    }

    /**
     * @dataProvider providerDecimalToDegreeDecimal
     */
    public function testDecimalToDegreeDecimal(float $latitude, float $longitude, string $expected)
    {
        $result = Utils::decimalToDegreeDecimal($latitude, $longitude);

        $this->assertEquals($expected, $result);
    }

    public static function providerReferenceCode()
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
        $this->assertIsInt($result);
    }

    public static function providerReferenceCodeFail()
    {
        return [
            ['GC', 'referenceCode "GC" too short.'],
            ['GCSRTOP', 'Only chars 0123456789ABCDEFGHJKMNPQRTVWXYZ are supported.'],
        ];
    }

    /**
     * @dataProvider providerReferenceCodeFail
     */
    public function testReferenceCodeToIdFail(string $referenceCode, string $expected)
    {
        $this->expectException(Geocaching\Exception\UtilsException::class);
        $this->expectExceptionMessage($expected);

        Utils::referenceCodeToId($referenceCode);
    }

    public static function providerId()
    {
        return [
            ['0', 'GC', 'GC'],
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
        $this->assertIsString($result);
    }

    public static function providerGeocodes()
    {
        return [
            ['GC12345', true],
            ['PR12345', false],
        ];
    }

    /**
     * @dataProvider providerGeocodes
     */
    public function testGeocodes(string $geocode, bool $expected): void
    {
        $result = Utils::isGeocode($geocode);

        $this->assertEquals($expected, $result);
    }

    public static function providerReferenceCodes()
    {
        return [
            ['', '', false],
            ['', 'GC', false],
            ['GC', '', false],
            ['GC', 'GC', false],
            ['GC2X3Y6', 'GC', true],
            ['GL19JDPRE', 'GL', true],
            ['PR2X3Y6', 'PR', true],
            ['gc2x3y6', 'GC', true],
            ['GCA234I', 'GC', false],
            ['GCA234L', 'GC', false],
            ['GCA234O', 'GC', false],
            ['GCA234S', 'GC', false],
        ];
    }

    /**
     * @dataProvider providerReferenceCodes
     */
    public function testReferenceCodes(string $geocode, string $prefix, bool $expected): void
    {
        $result = Utils::isReferenceCode($geocode, $prefix);

        $this->assertEquals($expected, $result);
    }
}
