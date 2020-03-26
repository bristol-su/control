x   # Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.2] - (26/03/2020)

### Removed
- Always loading control factories

### Changed
- Only load control factories when the faker class exists

## [1.2.1] - (18/03/2020)

### Added
- .gitattributes file

### Fixed
- Reference correct config file when publishing

## [1.2] - (04/02/2020)

### Changed
- DataGroupRepository::getWhere allows searching with additional attributes
- DataUserRepository::getWhere allows searching with additional attributes
- DataRoleRepository::getWhere allows searching with additional attributes
- DataPositionRepository::getWhere allows searching with additional attributes

## [1.1] - (04/02/2020)

### Changed
- Retrieve additional attributes through a static function in HasAdditionalProperties trait

### Fixed
- StoreRoleRequest position_name validation changed to role_name

### Added
- Save additional attribute function to set and save an additional attribute in one call
- Allow creation of and editing of additional attributes through the User API
- Allow creation of and editing of additional attributes through the Group API
- Allow creation of and editing of additional attributes through the Role API
- Allow creation of and editing of additional attributes through the Position API

## [1.0.2] - (03/02/2020)

### Fixed
- Default additional_attributes column to an empty array if null

## [1.0.1] - (02/02/2020)

### Fixed
- Removed default value for JSON column in database

## [1.0] - (30/01/2020)

### Added
- API
- model/repository implementations
- model/repository contracts


[Unreleased]: https://github.com/bristol-su/control/compare/v1.2.1...HEAD
[1.2.1]: https://github.com/bristol-su/control/compare/v1.2...v1.2.1
[1.2]: https://github.com/bristol-su/control/compare/v1.1...v1.2
[1.1]: https://github.com/bristol-su/control/compare/v1.0.2...v1.1
[1.0.2]: https://github.com/bristol-su/control/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/bristol-su/control/compare/v1.0...v1.0.1
[1.0]: https://github.com/bristol-su/control/releases/tag/v1.0
