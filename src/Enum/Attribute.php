<?php

namespace Geocaching\Enum;

enum Attribute: string
{
    use EnumTrait;

    case DOGS                           = 'Dogs';
    case ACCESS_PARKING_FEE             = 'Access/parking fee';
    case CLIMBING_GEAR_REQUIRED         = 'Climbing gear required';
    case BOAT_REQUIRED                  = 'Boat required';
    case SCUBA_GEAR_REQUIRED            = 'Scuba gear required';
    case RECOMMENDED_FOR_KIDS           = 'Recommended for kids';
    case TAKES_LESS_THAN_ONE_HOUR       = 'Takes less than one hour';
    case SCENIC_VIEW                    = 'Scenic view';
    case SIGNIFICANT_HIKE               = 'Significant hike';
    case DIFFICULT_CLIMB                = 'Difficult climb';
    case MAY_REQUIRE_WADING             = 'May require wading';
    case MAY_REQUIRE_SWIMMING           = 'May require swimming';
    case AVAILABLE_24_7                 = 'Available 24/7';
    case RECOMMENDED_AT_NIGHT           = 'Recommended at night';
    case AVAILABLE_IN_WINTER            = 'Available in winter';
    case CACTUS                         = 'Cactus';
    case POISONOUS_PLANTS               = 'Poisonous plants';
    case DANGEROUS_ANIMALS              = 'Dangerous animals';
    case TICKS                          = 'Ticks';
    case ABANDONED_MINE                 = 'Abandoned mine';
    case CLIFF_FALLING_ROCKS            = 'Cliff/falling rocks';
    case HUNTING_AREA                   = 'Hunting area';
    case DANGEROUS_AREA                 = 'Dangerous area';
    case WHEELCHAIR_ACCESSIBLE          = 'Wheelchair accessible';
    case PARKING_NEARBY                 = 'Parking nearby';
    case PUBLIC_TRANSPORTATION_NEARBY   = 'Public transportation nearby';
    case DRINKING_WATER_NEARBY          = 'Drinking water nearby';
    case PUBLIC_RESTROOMS_NEARBY        = 'Public restrooms nearby';
    case TELEPHONE_NEARBY               = 'Telephone nearby';
    case PICNIC_TABLES_NEARBY           = 'Picnic tables nearby';
    case CAMPING_NEARBY                 = 'Camping nearby';
    case BICYCLES                       = 'Bicycles';
    case MOTORCYCLES                    = 'Motorcycles';
    case QUADS                          = 'Quads';
    case OFF_ROAD_VEHICLES              = 'Off-road vehicles';
    case SNOWMOBILES                    = 'Snowmobiles';
    case HORSES                         = 'Horses';
    case CAMPFIRES                      = 'Campfires';
    case THORNS                         = 'Thorns';
    case STEALTH_REQUIRED               = 'Stealth required';
    case STROLLER_ACCESSIBLE            = 'Stroller accessible';
    case NEEDS_MAINTENANCE              = 'Needs maintenance';
    case LIVESTOCK_NEARBY               = 'Livestock nearby';
    case FLASHLIGHT_REQUIRED            = 'Flashlight required';
    case LOST_AND_FOUND_TOUR            = 'Lost and Found tour';
    case TRUCKS_RVS                     = 'Trucks/RVs';
    case FIELD_PUZZLE                   = 'Field puzzle';
    case UV_LIGHT_REQUIRED              = 'UV light required';
    case MAY_REQUIRE_SNOWSHOES          = 'May require snowshoes';
    case MAY_REQUIRE_CROSS_COUNTRY_SKIS = 'May require cross country skis';
    case SPECIAL_TOOL_REQUIRED          = 'Special tool required';
    case NIGHT_CACHE                    = 'Night cache';
    case PARK_AND_GRAB                  = 'Park and grab';
    case ABANDONED_STRUCTURE            = 'Abandoned structure';
    case SHORT_HIKE_1_KM                = 'Short hike (<1 km)';
    case MEDIUM_HIKE_1_KM_10_KM         = 'Medium hike (1 km–10 km)';
    case LONG_HIKE_10_KM                = 'Long hike (>10 km)';
    case FUEL_NEARBY                    = 'Fuel nearby';
    case FOOD_NEARBY                    = 'Food nearby';
    case WIRELESS_BEACON                = 'Wireless beacon';
    case PARTNERSHIP_CACHE              = 'Partnership cache';
    case SEASONAL_ACCESS                = 'Seasonal access';
    case RECOMMENDED_FOR_TOURISTS       = 'Recommended for tourists';
    case TREE_CLIMBING_REQUIRED         = 'Tree climbing required';
    case YARD_PRIVATE_RESIDENCE         = 'Yard (private residence)';
    case TEAMWORK_CACHE                 = 'Teamwork cache';
    case GEOTOUR                        = 'GeoTour';
    case BONUS_CACHE                    = 'Bonus cache';
    case POWER_TRAIL                    = 'Power trail';
    case CHALLENGE_CACHE                = 'Challenge cache';
    case GEOCACHING_SOLUTION_CHECKER    = 'Geocaching.com solution checker';

    public function id(): int
    {
        return match ($this) {
            self::DOGS                           =>  1,
            self::ACCESS_PARKING_FEE             =>  2,
            self::CLIMBING_GEAR_REQUIRED         =>  3,
            self::BOAT_REQUIRED                  =>  4,
            self::SCUBA_GEAR_REQUIRED            =>  5,
            self::RECOMMENDED_FOR_KIDS           =>  6,
            self::TAKES_LESS_THAN_ONE_HOUR       =>  7,
            self::SCENIC_VIEW                    =>  8,
            self::SIGNIFICANT_HIKE               =>  9,
            self::DIFFICULT_CLIMB                => 10,
            self::MAY_REQUIRE_WADING             => 11,
            self::MAY_REQUIRE_SWIMMING           => 12,
            self::AVAILABLE_24_7                 => 13,
            self::RECOMMENDED_AT_NIGHT           => 14,
            self::AVAILABLE_IN_WINTER            => 15,
            self::CACTUS                         => 16,
            self::POISONOUS_PLANTS               => 17,
            self::DANGEROUS_ANIMALS              => 18,
            self::TICKS                          => 19,
            self::ABANDONED_MINE                 => 20,
            self::CLIFF_FALLING_ROCKS            => 21,
            self::HUNTING_AREA                   => 22,
            self::DANGEROUS_AREA                 => 23,
            self::WHEELCHAIR_ACCESSIBLE          => 24,
            self::PARKING_NEARBY                 => 25,
            self::PUBLIC_TRANSPORTATION_NEARBY   => 26,
            self::DRINKING_WATER_NEARBY          => 27,
            self::PUBLIC_RESTROOMS_NEARBY        => 28,
            self::TELEPHONE_NEARBY               => 29,
            self::PICNIC_TABLES_NEARBY           => 30,
            self::CAMPING_NEARBY                 => 31,
            self::BICYCLES                       => 32,
            self::MOTORCYCLES                    => 33,
            self::QUADS                          => 34,
            self::OFF_ROAD_VEHICLES              => 35,
            self::SNOWMOBILES                    => 36,
            self::HORSES                         => 37,
            self::CAMPFIRES                      => 38,
            self::THORNS                         => 39,
            self::STEALTH_REQUIRED               => 40,
            self::STROLLER_ACCESSIBLE            => 41,
            self::NEEDS_MAINTENANCE              => 42,
            self::LIVESTOCK_NEARBY               => 43,
            self::FLASHLIGHT_REQUIRED            => 44,
            self::LOST_AND_FOUND_TOUR            => 45,
            self::TRUCKS_RVS                     => 46,
            self::FIELD_PUZZLE                   => 47,
            self::UV_LIGHT_REQUIRED              => 48,
            self::MAY_REQUIRE_SNOWSHOES          => 49,
            self::MAY_REQUIRE_CROSS_COUNTRY_SKIS => 50,
            self::SPECIAL_TOOL_REQUIRED          => 51,
            self::NIGHT_CACHE                    => 52,
            self::PARK_AND_GRAB                  => 53,
            self::ABANDONED_STRUCTURE            => 54,
            self::SHORT_HIKE_1_KM                => 55,
            self::MEDIUM_HIKE_1_KM_10_KM         => 56,
            self::LONG_HIKE_10_KM                => 57,
            self::FUEL_NEARBY                    => 58,
            self::FOOD_NEARBY                    => 59,
            self::WIRELESS_BEACON                => 60,
            self::PARTNERSHIP_CACHE              => 61,
            self::SEASONAL_ACCESS                => 62,
            self::RECOMMENDED_FOR_TOURISTS       => 63,
            self::TREE_CLIMBING_REQUIRED         => 64,
            self::YARD_PRIVATE_RESIDENCE         => 65,
            self::TEAMWORK_CACHE                 => 66,
            self::GEOTOUR                        => 67,
            self::BONUS_CACHE                    => 69,
            self::POWER_TRAIL                    => 70,
            self::CHALLENGE_CACHE                => 71,
            self::GEOCACHING_SOLUTION_CHECKER    => 72,
        };
    }
}
