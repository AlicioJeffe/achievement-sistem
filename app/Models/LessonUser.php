<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'lesson_user';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'watched'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function lesson()
    {
        return $this->hasOne(Lesson::class,'id','lesson_id');
    }
}
