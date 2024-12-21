<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanUseTickets
{
    use HasApiTokens, HasFactory, Notifiable, HasTickets, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function loginType($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        $input = preg_replace('/[^0-9]/', '', $input);

        if (substr($input, 0, 1) === '0') {
            $input = substr($input, 1);
        }

        if (substr($input, 0, 2) === '98') {
            $input = substr($input, 2);
        }

        return 'mobile';
    }
}
