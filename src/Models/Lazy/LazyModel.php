<?php

namespace BristolSU\ControlDB\Models\Lazy;

abstract class LazyModel
{

    protected int $lazyId;

    protected $model = null;

    public function __construct(int $id)
    {
        $this->lazyId = $id;
    }


    public static function lazy(int $id)
    {
        return new static($id);
    }

    protected function model()
    {
        if($this->model === null) {
            $this->model = $this->resolveModelFromId($this->lazyId);
        }
        return $this->model;
    }

    abstract protected function resolveModelFromId(int $id);

}
