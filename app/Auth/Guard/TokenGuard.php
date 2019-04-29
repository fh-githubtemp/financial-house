<?php

namespace App\Auth\Guard;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;

class TokenGuard implements Guard
{
    const TOKEN_SESSION_KEY = '_report_token_';
    protected $user;

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        if (is_null($this->user)) {
            $this->validate();
        }

        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->getAuthIdentifier();
        }

        return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $token = Session::get(self::TOKEN_SESSION_KEY);
        if (!$token) {
            return false;
        }
        $token = json_decode($token, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Session::remove(self::TOKEN_SESSION_KEY);

            return false;
        }
        if (Carbon::createFromTimestamp($token['expiry'])->isPast()) {
            Session::remove(self::TOKEN_SESSION_KEY);

            return false;
        }
        $this->user = new User([
            'id'    => $token['token'],
            'token' => $token,
        ]);

        return true;
    }

    /**
     * Set the current user.
     *
     * @param Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }
}
