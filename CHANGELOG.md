# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.19.0] - 2023-02-09
### Added
    - Compatibility with PHP 8.2 and monolog 3.0

## [3.18.0] - 2021-03-24
### Added
    - Compatibility with PHP 8.1
    - New API method added:
        - getUserPrivacySettings
        - getAdventure

## [3.16.0] - 2021-08-06
### Added
    - Better exception management

## [3.15.0] - 2021-05-22
### Added
    - New API method added:
        - searchAdventures
        - getGeocacheLogUpvotes
        - deleteGeocacheLogUpvotes
        - setGeocacheLogUpvotes
        - getUserTrackableLog
    - New Enums added:
        - AdditionalWaypointType
        - GeocacheLogUpvoteType
    - Improved http errors management

## [3.14.0] - 2021-01-19
### Added
    - Throw an exception if the referenceCode is too short

## [3.13.0] - 2021-01-17
### Added
    - New API method added:
        - getWherigoCartridge
    - Compatibility with PHP >= 8.0

## [3.12.0] - 2020-09-21
### Added
    - New API methods added:
        - getGeocacheSizes
        - getGeocacheStatuses
        - getTrackableJourneys
        - getOptedOutUsers

## [3.11.0] - 2020-05-22
### Added
    - http options [from Guzzle](http://docs.guzzlephp.org/en/stable/request-options.html) added to all methods if needed (last argument)