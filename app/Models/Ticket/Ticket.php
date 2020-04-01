<?php


namespace App\Models\Ticket;

use App\Models\Ticket\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Ticket extends Model
{
    use Sortable;

    protected $table = 'ticket_tickets';
    protected $fillable = [
        'subject', 'content', 'user_id', 'admin_id'
    ];
    protected $dates = ['created_at'];
    public $sortable = [
        'id',
        'subject',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function addMessage(int $userId, $message)
    {
        $message = $this->messages()->create([
            'user_id' => $userId,
            'message' => $message,
        ]);
        $this->touch();

        return $message;
    }

    public static function lastForUser(User $user)
    {
        return $user->tickets()->latest()->first();
    }

    public function takeByAdmin(int $adminId)
    {
        $this->update(['admin_id' => $adminId]);
        $this->status->setStatusTaken();
    }

}
