<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'problem', 'approach', 'result',
        'tech_stack', 'image', 'demo_video', 'github_link', 'demo_link',
    ];
}
