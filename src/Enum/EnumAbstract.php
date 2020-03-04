<?php

namespace Geocaching\Enum;

use Geocaching\Exception\EnumException;

class EnumAbstract
{
    /**
     * @var array
     */
    protected static $list = [];

    public static function getList(): array
    {
        return static::$list;
    }

    public static function getId(string $name): int
    {
        $id = array_search($name, static::$list);

        if ($id === false) {
            throw new EnumException('Invalid Name: ' . $name);
        }

        return (int) $id;
    }

    public static function getName(int $id): string
    {
        if (!array_key_exists($id, static::$list)) {
            throw new EnumException('Invalid ID: ' . $id);
        }

        return static::$list[$id];
    }
}
