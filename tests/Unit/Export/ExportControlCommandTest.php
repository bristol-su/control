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
            User::factory()->create(),
            User::factory()->create(),
            User::factory()->create(),
            User::factory()->create()
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
            Group::factory()->create(),
            Group::factory()->create(),
            Group::factory()->create(),
            Group::factory()->create()
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
            Role::factory()->create(),
            Role::factory()->create(),
            Role::factory()->create(),
            Role::factory()->create()
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
            Position::factory()->create(),
            Position::factory()->create(),
            Position::factory()->create(),
            Position::factory()->create()
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
            User::factory()->create(),
            User::factory()->create(),
            User::factory()->create(),
            User::factory()->create()
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
