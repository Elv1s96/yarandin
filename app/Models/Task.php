<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'project_id','status','file_name'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
