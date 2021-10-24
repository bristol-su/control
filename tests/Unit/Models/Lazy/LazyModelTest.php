<?php

namespace BristolSU\Tests\ControlDB\Unit\Models\Lazy;

use BristolSU\ControlDB\Models\Lazy\LazyModel;
use BristolSU\Tests\ControlDB\TestCase;

class LazyModelTest extends TestCase
{

    /** @test */
    public function it_loads_a_model_from_an_id(){
        $lazyModel = new DummyLazyModel(3);
        $lazyModel->callback = fn(int $id) => ['actual' => 'model'];
        $this->assertEquals(['actual' => 'model'], $lazyModel->getModel());
    }

}

class DummyLazyModel extends LazyModel
{
    public $callback;

    protected function resolveModelFromId(int $id)
    {
        return ($this->callback)($id);
    }

    public function getModel()
    {
        return $this->model();
    }
}
