<?php


namespace App\Models\Ticket;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'ticket_messages';
    protected $fillable = [
        'ticked_id', 'user_id', 'message'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
