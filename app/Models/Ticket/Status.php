<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'ticket_statuses';
    protected $fillable = ['ticket_id', 'is_seen', 'is_closed', 'is_answered', 'is_taken'];
    public $timestamps = false;
    public $sortable = ['is_closed', 'is_answered', 'is_seen', 'is_taken'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function setStatusAnswered(bool $isAnswered)
    {
        $data = $isAnswered ? 1: 0;
        $this->update(['is_answered' => $data]);
    }

    public function setStatusSeen(bool $isSeen)
    {
        $data = $isSeen ? 1: 0;
        $this->update(['is_seen' => $data]);
    }

    public function setStatusTaken()
    {
        $this->update(['is_taken' => 1]);
    }

    public function setStatusClose()
    {
        $this->update(['is_closed' => 1]);
    }

    public function isClose() : bool
    {
        return (bool) $this->is_closed;
    }
}
