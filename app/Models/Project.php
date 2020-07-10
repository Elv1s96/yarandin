<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'file_name','user_id'];
public function users()
{
    return $this->belongsToMany(User::class);
}

}
