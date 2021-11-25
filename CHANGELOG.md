# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed
- Made exports more memory efficient

## [3.1.0] - (24/10/2021)

### Added
- Lazy models for lazyloading of control models through repositories
- Events fired on all repository actions with side effects

### Fixed
- Reduced scope of some cache to avoid lingering changes not being cleared

## [3.0.2] - (23/10/2021)

### Added
- Dummy models that can be substituted for models that have been deleted

## [3.0.1] - (05/08/2021)

### Changed
- Use new Laravel factories rather than legacy factories.

## [3.0.0] - (05/08/2021)

### Changed
- Upgrades to use Laravel 8

## [2.1.5] - (16/06/2020)

### Removed
- Removed the AirTable integration since it is now provided by an external package

## [2.1.4] - (15/06/2020)

### Added
- Added the Airtable export handler for exporting control

## [2.1.3] - (01/05/2020)

### Changed
- Passing null to DataUserController::update sets a field to null
- Passing null to DataGroupController::update sets a field to null
- Passing null to DataRoleController::update sets a field to null
- Passing null to DataPositionController::update sets a field to null

### Fixed
- DataUserNotify notified create method on updating

## [2.1.2] - (28/04/2020)

### Fixed
- DataUser::getAllWhere matched any base attributes not all base attributes
- DataGroup::getAllWhere matched any base attributes not all base attributes
- DataRole::getAllWhere matched any base attributes not all base attributes
- DataPosition::getAllWhere matched any base attributes not all base attributes

## [2.1.1] - (27/04/2020)

### Changed
- Return date format of Y-m-d h:i:s for data user date of birth

## [2.1] - (27/04/2020)

### Added
- Repositories to cache all get repository calls
- Observer framework for repositories
- Clear cache when needed
- Cascade deletes to preserve data integrity

## [2.0] - (22/04/2020)

### Added
- \BristolSU\ControlDB\Contracts\Repositories\User::paginate()
- \BristolSU\ControlDB\Contracts\Repositories\User::count()
- \BristolSU\ControlDB\Contracts\Repositories\DataUser::getAllWhere()
- \BristolSU\ControlDB\Contracts\Repositories\Group::paginate()
- \BristolSU\ControlDB\Contracts\Repositories\Group::count()
- \BristolSU\ControlDB\Contracts\Repositories\DataGroup::getAllWhere()
- \BristolSU\ControlDB\Contracts\Repositories\Role::paginate()
- \BristolSU\ControlDB\Contracts\Repositories\Role::count()
- \BristolSU\ControlDB\Contracts\Repositories\DataRole::getAllWhere()
- \BristolSU\ControlDB\Contracts\Repositories\Position::paginate()
- \BristolSU\ControlDB\Contracts\Repositories\Position::count()
- \BristolSU\ControlDB\Contracts\Repositories\DataPosition::getAllWhere()
- \BristolSU\ControlDB\Http\Controllers\Controller::paginate to slice and paginate through a list of items
- \BristolSU\ControlDB\Http\Controllers\Controller::paginationResponse to paginate through a sliced list of items
- Add timings of formatters to logs when exporting

### Changed
- \BristolSU\ControlDB\Http\Controllers\Group\GroupController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Group\GroupGroupTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Group\GroupRoleController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Group\GroupUserController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\GroupTag\GroupTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\GroupTag\GroupTagGroupController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\GroupTagCategory\GroupTagCategoryController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\GroupTagCategory\GroupTagCategoryGroupTagController::index returns a LengthAwarePaginator

- \BristolSU\ControlDB\Http\Controllers\Position\PositionController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Position\PositionPositionTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Position\PositionRoleController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\PositionTag\PositionTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\PositionTag\PositionTagPositionController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\PositionTagCategory\PositionTagCategoryController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\PositionTagCategory\PositionTagCategoryPositionTagController::index returns a LengthAwarePaginator

- \BristolSU\ControlDB\Http\Controllers\Role\RoleController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Role\RoleRoleTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\Role\RoleUserController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\RoleTag\RoleTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\RoleTag\RoleTagRoleController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\RoleTagCategory\RoleTagCategoryController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\RoleTagCategory\RoleTagCategoryRoleTagController::index returns a LengthAwarePaginator

- \BristolSU\ControlDB\Http\Controllers\User\UserController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\User\UserGroupController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\User\UserRoleController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\User\UserUserTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\UserTag\UserTagController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\UserTag\UserTagUserController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\UserTagCategory\UserTagCategoryController::index returns a LengthAwarePaginator
- \BristolSU\ControlDB\Http\Controllers\UserTagCategory\UserTagCategoryUserTagController::index returns a LengthAwarePaginator

## [1.3.0] - (08/04/2020)

### Added
- Create the exporter framework for exporting control information

## [1.2.4] - (03/04/2020)

### Changed
- Return a full_reference attribute in the tag model by default

## [1.2.3] - (02/04/2020)

### Changed
- Updated repositories to use findOrFail

### Added
- Role Caching

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


[Unreleased]: https://github.com/bristol-su/control/compare/v2.1.5...HEAD
[2.1.5]: https://github.com/bristol-su/control/compare/v2.1.4...v2.1.5
[2.1.4]: https://github.com/bristol-su/control/compare/v2.1.3...v2.1.4
[2.1.3]: https://github.com/bristol-su/control/compare/v2.1.2...v2.1.3
[2.1.2]: https://github.com/bristol-su/control/compare/v2.1.1...v2.1.2
[2.1.1]: https://github.com/bristol-su/control/compare/v2.1...v2.1.1
[2.1]: https://github.com/bristol-su/control/compare/v2.0...v2.1
[2.0]: https://github.com/bristol-su/control/compare/v1.3.0...v2.0
[1.3.0]: https://github.com/bristol-su/control/compare/v1.2.4...v1.3.0
[1.2.4]: https://github.com/bristol-su/control/compare/v1.2.3...v1.2.4
[1.2.3]: https://github.com/bristol-su/control/compare/v1.2.2...v1.2.3
[1.2.2]: https://github.com/bristol-su/control/compare/v1.2.1...v1.2.2
[1.2.1]: https://github.com/bristol-su/control/compare/v1.2...v1.2.1
[1.2]: https://github.com/bristol-su/control/compare/v1.1...v1.2
[1.1]: https://github.com/bristol-su/control/compare/v1.0.2...v1.1
[1.0.2]: https://github.com/bristol-su/control/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/bristol-su/control/compare/v1.0...v1.0.1
[1.0]: https://github.com/bristol-su/control/releases/tag/v1.0
