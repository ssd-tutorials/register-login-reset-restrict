<?php

namespace App\Models;

use App\Utilities\Hash;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'active',
        'name',
        'email',
        'password',
        'token',
        'remember_token'
    ];

    /**
     * Hash password.
     *
     * @param string $password
     * @return string
     */
    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Verify password.
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return Hash::verify($password, $this->password);
    }

    /**
     * Get record by email.
     *
     * @param Builder $query
     * @param string $email
     * @return Builder
     */
    public function scopeByEmail(Builder $query, $email)
    {
        return $query->where('email', $email);
    }

    /**
     * Get record by token.
     *
     * @param Builder $query
     * @param string $token
     * @return Builder
     */
    public function scopeByToken(Builder $query, $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Get record by remember me token.
     *
     * @param Builder $query
     * @param string $token
     * @return Builder
     */
    public function scopeByRememberToken(Builder $query, $token)
    {
        return $query->where('remember_token', $token);
    }

    /**
     * Set and get token.
     *
     * @return string
     */
    public function resetToken()
    {
        $this->token = uniqid().md5($this->email);
        $this->save();

        return $this->token;
    }

    /**
     * Check if user has active account.
     *
     * @return bool
     */
    public function isActive()
    {
        return (int) $this->active === 1;
    }

    /**
     * Activate user account.
     *
     * @return $this
     */
    public function makeActive()
    {
        $this->active = 1;
        $this->token = null;
        $this->save();

        return $this;
    }

    /**
     * Update password.
     *
     * @param string $password
     * @return $this
     */
    public function updatePassword($password)
    {
        $this->active = 1;
        $this->token = null;
        $this->password = $password;
        $this->save();

        return $this;
    }

    /**
     * Update remember me token.
     *
     * @return $this
     */
    public function updateRememberToken()
    {
        $this->remember_token = hash('sha256', Str::random());
        $this->save();

        return $this;
    }
}












