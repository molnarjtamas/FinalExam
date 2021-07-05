<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'start_date',
        'end_date',
        'approved',
    ];

    /**
     * The attributes that are type of date.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * Defines the relation between User and Holiday models.
     * A holiday belongs to exactly one user.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
