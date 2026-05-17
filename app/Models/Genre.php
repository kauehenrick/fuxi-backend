<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $attributes = [
        'deleted_at' => null,
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
