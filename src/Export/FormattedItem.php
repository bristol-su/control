<?php

namespace BristolSU\ControlDB\Export;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class FormattedItem implements Arrayable, Jsonable
{

    /**
     * The original item
     * 
     * @var mixed
     */
    private $original;

    /**
     * Formatted items to prepare
     * 
     * @var array
     */
    private $prepared = [];

    public function __construct($original)
    {
        $this->original = $original;
    }

    public static function create($original)
    {
        return new static($original);
    }

    public function original()
    {
        return $this->original;
    }

    public function isType(string $type)
    {
        return $this->original() instanceof $type;
    }

    
    public function addRow($key, $value)
    {
        $this->prepared[$key] = $value;
    }

    public function getColumnNames()
    {
        return array_keys($this->prepared);
    }
    
    public function getItem($column, $default = null)
    {
        if(array_key_exists($column, $this->prepared) && $this->prepared[$column] !== null) {
            return $this->prepared[$column];
        }
        return $default;
    }
    
    public function preparedItems(): array
    {
        return $this->prepared;
    }
    
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->preparedItems();
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), 0);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}