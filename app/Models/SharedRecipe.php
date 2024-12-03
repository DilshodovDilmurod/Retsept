<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SharedRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'shared_by_user_id',
        'shared_with_user_id',
    ];

    // Relationships
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by_user_id');
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with_user_id');
    }
}
