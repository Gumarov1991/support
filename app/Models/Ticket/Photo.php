<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'ticket_photos';
    protected $fillable = ['ticket_id', 'file'];
    public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
