<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table ='tasks';
    protected $fillable = [
    'id',
    'title',
    'body',
    'admin_id',
    'datetime',
    
];


    public function user(){
        return $this->belongsTo(User::class);
    }
   
}
