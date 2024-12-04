<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $table = 'labels';

    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = true;

    # M ke M
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_labels', 'label_id', 'contact_id')->withTimestamps();
    }
}
