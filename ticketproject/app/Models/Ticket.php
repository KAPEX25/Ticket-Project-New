<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'category',
        'impact',
        'source',
        'assigned_user_id',
        'created_by_user_id',
        'sla_due_date',
        'resolved_at',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($ticket) {
            if (auth()->check() && auth()->user()->hasRole('agent')) {
                if ($ticket->status === 'Resolved' && is_null($ticket->resolved_at)) {
                    $ticket->assigned_user_id = auth()->id();
                    $ticket->resolved_at = now();
                }
            }
        });
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
