<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['name', 'bio', 'photo', 'cv_file', 'linkedin', 'github'];
}
