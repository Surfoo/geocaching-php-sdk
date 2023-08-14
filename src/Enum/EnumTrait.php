<?php

namespace Geocaching\Enum;

trait EnumTrait
{
    public static function fromId(int $id): self
    {
        foreach (self::cases() as $item) {
            if ($item->id() === $id) {
                return $item;
            }
        }

        throw new \ValueError("Invalid Enum Id, given: " . $id);
    }
}
