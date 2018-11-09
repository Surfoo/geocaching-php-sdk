<?php

namespace Geocaching\Lib\Utils;

class Utils
{

    /**
     * @const string
     */
    const BASE_31_CHARS = "0123456789ABCDEFGHJKMNPQRTVWXYZ";

    /**
     * (16 * 31 * 31 * 31) - (16 * 16 * 16 * 16)
     *
     * @const int
     */
    const CACHE_CODE_BASE31_MAGIC_NUMBER = 411120;

    /**
     * @const int
     */
    const CACHE_CODE_BASE16_MAX = 0xFFFF;

    /**
     * Concert a reference code to an Id
     *
     * @param string $referenceCode
     *
     * @return int
     */
    public static function referenceCodeToId(string $referenceCode): int
    {
        if (\substr($referenceCode, 0, 2) == 'GC') {
            $referenceCode = \str_replace('SO', '50', $referenceCode);
        }

        $referenceCode = \substr($referenceCode, 2);

        $firstChar = \substr($referenceCode, 0, 1);

        if (\strlen($referenceCode) >= 5 || !\strpos('0123456789ABCDEF', $firstChar)) {
            return self::base31Decode($referenceCode) - self::CACHE_CODE_BASE31_MAGIC_NUMBER;
        }

        return (int) \base_convert($referenceCode, 16, 10);
    }

    /**
     * Convert a numeric id to a reference Code.
     *
     * @param string $number
     * @param string $prefix
     *
     * @return string
     */
    public static function idToReferenceCode(string $number, string $prefix): string
    {
        if ($number <= self::CACHE_CODE_BASE16_MAX) {
            $result = \strtoupper(\base_convert($number, 10, 16));
        } else {
            $result = self::base31Encode((int) $number + self::CACHE_CODE_BASE31_MAGIC_NUMBER);
        }

        if ($result[0] == '0') {
            $result = \substr($result, 1);
        }
        return $prefix . $result;
    }

    /**
     * Convert a base 31 number containing chars 0123456789ABCDEFGHJKMNPQRTVWXYZ
     * to numeric value.
     *
     * @param  string     $input
     * @return int
     * @throws \Exception Only chars 0123456789ABCDEFGHJKMNPQRTVWXYZ are supported.
     */
    protected static function base31Decode(string $input): int
    {
        $base   = \strlen(self::BASE_31_CHARS);
        $result = 0;

        $inputList = \str_split($input);
        foreach ($inputList as $ch) {
            $result *= $base;

            $index = \strpos(self::BASE_31_CHARS, $ch);
            if ($index === false) {
                throw new \Exception("Only chars " . self::BASE_31_CHARS . " are supported.");
            }

            $result += $index;
        }

        return $result;
    }

    /**
     * Convert a numeric value to base 31 number using chars
     * ABCDEFGHJKMNPQRTVWXYZ0123456789.
     *
     * @param int $input
     *
     * @return string
     */
    protected static function base31Encode(int $input): string
    {
        $result = '';

        while ($input > 0) {
            $result .= self::BASE_31_CHARS[$input % 31];
            $input = (int) $input / 31;
        }

        return \strrev($result);
    }
}
