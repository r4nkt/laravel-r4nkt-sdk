<?php

namespace R4nkt\LaravelR4nkt\Concerns;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Requires
{
    public function __construct(
        public string $required,
    ) {}

    public function __toString()
    {
        return $this->required;
    }
}
