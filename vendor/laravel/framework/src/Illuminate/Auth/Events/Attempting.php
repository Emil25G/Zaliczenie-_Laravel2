<?php

namespace Illuminate\Auth\Events;

class Attempting
{
    /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The credentials for the users.
     *
     * @var array
     */
    public $credentials;

    /**
     * Indicates if the users should be "remembered".
     *
     * @var bool
     */
    public $remember;

    /**
     * Create a new event instance.
     *
     * @param  string  $guard
     * @param  array  $credentials
     * @param  bool  $remember
     * @return void
     */
    public function __construct($guard, #[\SensitiveParameter] $credentials, $remember)
    {
        $this->guard = $guard;
        $this->remember = $remember;
        $this->credentials = $credentials;
    }
}
