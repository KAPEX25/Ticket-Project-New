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
}
