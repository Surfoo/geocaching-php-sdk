<?php

namespace Geocaching\Enum;

trait EnumTrait
{
    /**
     * Search an enum from an id
     */
    public static function fromId(int $id): self
    {
        foreach (self::cases() as $item) {
            if ($item->id() === $id) {
                return $item;
            }
        }

        throw new \ValueError("Invalid Enum Id, given: " . $id);
    }

    /**
     * Return the list of human readables values
     */
    public static function getList(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Return the list of ids
     */
    public static function getListId(): array
    {
        return array_map(fn(self $enum) => $enum->id(), self::cases());
    }
}
