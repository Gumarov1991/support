<?php

namespace App\Models;

use App\Models\Ticket\Message;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket\Ticket;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 10;
    const MAIN_ADMIN_ID = 1;

    protected $fillable = [
        'name', 'email', 'password'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $sortable = ['email'];


    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isAllowedToCreateTickets()
    {
        $lastTicketThisUser = Ticket::lastForUser($this);

        if ($lastTicketThisUser === null) {
            return true;
        }

        $lastTicketThisUserTime = Carbon::createFromTimestamp($lastTicketThisUser->created_at->getTimestamp());
        $oneDayAgo = Carbon::now()->subDay();

        return $lastTicketThisUserTime->lessThanOrEqualTo($oneDayAgo);
    }
}
