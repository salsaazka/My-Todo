<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'name',
        'user_id'
    ];
    //many nya di tasks
    //untuk table yang disambungkan juga membuat method dengan nama table , tanpa s/ es karena one
    public function project()
    {
        //untuk table yang disambungkan gunakan belongsTo
        return $this->belongsTo(Project::class);
    }
}
