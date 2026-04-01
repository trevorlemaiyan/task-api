<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // This tells Laravel which columns we are allowed to fill with data
    protected $fillable = ['title', 'due_date', 'priority', 'status'];

    // This ensures dates are treated correctly
    protected $casts = [
        'due_date' => 'date',
    ];
}