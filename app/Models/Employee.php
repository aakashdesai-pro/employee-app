<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'name',
        'dob',
        'phone',
        'photo',
        'email',
        'salary',
        'status'// ['active', 'not_active'],
    ];

    protected $casts = [
        'dob' => 'date',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function getPhotoUrlAttribute(){
        return config('app.url')."/photos/".$this->photo;
    }
}
