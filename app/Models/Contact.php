<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address'];
    public $timestamps = true;

    # M ke M
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'contact_labels', 'contact_id', 'label_id')->withTimestamps();
    }
}
