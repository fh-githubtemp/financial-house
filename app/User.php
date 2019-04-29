<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Arr;

class User implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;
    protected $properties = [];

    /**
     * User constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    public function getAuthIdentifierName()
    {
        return 'token';
    }

    public function getAuthIdentifier()
    {
        return Arr::get($this->properties, $this->getAuthIdentifierName());
    }
}
