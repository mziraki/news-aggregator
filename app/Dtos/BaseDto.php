<?php

namespace App\Dtos;

use Illuminate\Contracts\Support\Arrayable;

abstract class BaseDto implements Arrayable
{
    public function __toString()
    {
        return json_encode($this);
    }

    public function __toArray(): array
    {
        return (array) $this;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
