<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
    ];
    //menyambungkan antar table
    //syaratnya, didalam table yang mau disambungkan harus ada column yang berfungsi sebagai foreign key (column yang menyimpan value dari column primary key table awal: contoh project_id di table tasks)
    //penamaan method nya diambil dari table task yang mau disambungin

    //fungsinya untuk dapat mengambil data dari table task melalui table project
    //one di project
    public function tasks()
    {
        //hasMany untuk relasi one to many
        //hasOne untuk relas one to one
        //isi argument diambil dari nama model table yang mau disambungkan
        return $this->hasMany(Task::class);
    }
}
