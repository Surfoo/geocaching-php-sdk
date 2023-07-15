<?php

namespace Geocaching\Enum;

enum GeocacheLogType: string
{
    case FOUND_IT = 'Found It';
    case DID_NOT_FIND_IT = 'Didn\'t find it';
    case WRITE_NOTE = 'Write note';
    case ARCHIVE = 'Archive';
    case PERMANENTLY_ARCHIVED = 'Permanently Archived';
    case NEEDS_ARCHIVED = 'Needs Archived';
    case WILL_ATTEND = 'Will Attend';
    case ATTENDED = 'Attended';
    case WEBCAM_PHOTO_TAKEN = 'Webcam Photo Taken';
    case UNARCHIVE = 'Unarchive';
    case POST_REVIEWER_NOTE_DEPRECATED = 'Post Reviewer Note (deprecated)';
    case TEMPORARILY_DISABLE_LISTING = 'Temporarily Disable Listing';
    case ENABLE_LISTING = 'Enable Listing';
    case PUBLISH_LISTING = 'Publish Listing';
    case RETRACT_LISTING = 'Retract Listing';
    case NEEDS_MAINTENANCE = 'Needs Maintenance';
    case OWNER_MAINTENANCE = 'Owner maintenance';
    case UPDATE_COORDINATES = 'Update Coordinates';
    case POST_REVIEWER_NOTE = 'Post Reviewer Note';
    case ANNOUNCEMENT = 'Announcement';
    case SUBMIT_FOR_REVIEW = 'Submit for Review';

    public function id(): int
    {
        return match ($this) {
            self::FOUND_IT => 2,
            self::DID_NOT_FIND_IT => 3,
            self::WRITE_NOTE => 4,
            self::ARCHIVE => 5,
            self::PERMANENTLY_ARCHIVED => 6,
            self::NEEDS_ARCHIVED => 7,
            self::WILL_ATTEND => 9,
            self::ATTENDED => 10,
            self::WEBCAM_PHOTO_TAKEN => 11,
            self::UNARCHIVE => 12,
            self::POST_REVIEWER_NOTE_DEPRECATED => 18,
            self::TEMPORARILY_DISABLE_LISTING => 22,
            self::ENABLE_LISTING => 23,
            self::PUBLISH_LISTING => 24,
            self::RETRACT_LISTING => 25,
            self::NEEDS_MAINTENANCE => 45,
            self::OWNER_MAINTENANCE => 46,
            self::UPDATE_COORDINATES => 47,
            self::POST_REVIEWER_NOTE => 68,
            self::ANNOUNCEMENT => 74,
            self::SUBMIT_FOR_REVIEW => 76,
        };
    }
}
