<?php

namespace BristolSU\Tests\ControlDB\Unit\Export;

use BristolSU\ControlDB\Export\ExportControlCommand;
use BristolSU\ControlDB\Export\Exporter;
use BristolSU\ControlDB\Export\ExportManager;
use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Handler\Handler;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class ExportControlCommandTest extends TestCase
{

    /** @test */
    public function it_exports_all_users_if_the_data_type_is_a_user(){
        $users = collect([
            factory(User::class)->create(),
            factory(User::class)->create(),
            factory(User::class)->create(),
            factory(User::class)->create()
        ]);
        
        Exporter::extend('test', function($app, $config) {
            return $app->make(TestDriver::class, ['config' => $config]);
        });
        
        config()->set('control.export.default', 'test-setup');
        config()->set('control.export.test-setup', [
            'driver' => 'test',
            'shouldExport' => $users
        ]);
        
        $this->artisan(ExportControlCommand::class, ['type' => 'user']);
    }

    /** @test */
    public function it_exports_all_groups_if_the_data_type_is_a_group(){
        $groups = collect([
            factory(Group::class)->create(),
            factory(Group::class)->create(),
            factory(Group::class)->create(),
            factory(Group::class)->create()
        ]);

        Exporter::extend('test', function($app, $config) {
            return $app->make(TestDriver::class, ['config' => $config]);
        });

        config()->set('control.export.default', 'test-setup');
        config()->set('control.export.test-setup', [
            'driver' => 'test',
            'shouldExport' => $groups
        ]);

        $this->artisan(ExportControlCommand::class, ['type' => 'group']);
    }

    /** @test */
    public function it_exports_all_roles_if_the_data_type_is_a_role(){
        $roles = collect([
            factory(Role::class)->create(),
            factory(Role::class)->create(),
            factory(Role::class)->create(),
            factory(Role::class)->create()
        ]);

        Exporter::extend('test', function($app, $config) {
            return $app->make(TestDriver::class, ['config' => $config]);
        });

        config()->set('control.export.default', 'test-setup');
        config()->set('control.export.test-setup', [
            'driver' => 'test',
            'shouldExport' => $roles
        ]);

        $this->artisan(ExportControlCommand::class, ['type' => 'role']);
    }

    /** @test */
    public function it_exports_all_positions_if_the_data_type_is_a_position(){
        $positions = collect([
            factory(Position::class)->create(),
            factory(Position::class)->create(),
            factory(Position::class)->create(),
            factory(Position::class)->create()
        ]);

        Exporter::extend('test', function($app, $config) {
            return $app->make(TestDriver::class, ['config' => $config]);
        });

        config()->set('control.export.default', 'test-setup');
        config()->set('control.export.test-setup', [
            'driver' => 'test',
            'shouldExport' => $positions
        ]);

        $this->artisan(ExportControlCommand::class, ['type' => 'position']);
    }
    
    /** @test */
    public function it_uses_the_driver_if_given(){
        $users = collect([
            factory(User::class)->create(),
            factory(User::class)->create(),
            factory(User::class)->create(),
            factory(User::class)->create()
        ]);

        Exporter::extend('test', function($app, $config) {
            return $app->make(TestDriver::class, ['config' => $config]);
        });

        config()->set('control.export.default', 'default');
        config()->set('control.export.test-setup', [
            'driver' => 'test',
            'shouldExport' => $users
        ]);

        $this->artisan(ExportControlCommand::class, ['type' => 'user', '--exporter' => 'test-setup']);
    }
    
}

class TestDriver extends Handler
{

    public function export($items = [])
    {
        foreach($items as $key => $item) {
            Assert::assertTrue($item->is($this->config('shouldExport')[$key]));
        }
    }

    /**
     * @inheritDoc
     */
    protected function save(array $items)
    {
        // TODO: Implement save() method.
    }
}