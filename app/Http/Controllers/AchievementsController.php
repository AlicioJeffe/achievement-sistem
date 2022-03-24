<?php

namespace App\Http\Controllers;

use App\Events\LessonWatched;
use App\Models\LessonUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'unlocked_achievements' => [],
            'next_available_achievements' => [],
            'current_badge' => '',
            'next_badge' => '',
            'remaing_to_unlock_next_badge' => 0
        ]);
    }

    public function firstLessonWatched(Request $request)
    {
 
        
        $v = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'lesson_id' => 'required|numeric',
            'watched' => 'boolean'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ]);
        }

        try {

            $lessonUSer = new LessonUser();
            $lessonUSer->user_id = $request->user_id;
            $lessonUSer->lesson_id = $request->lesson_id;
            $lessonUSer->watched = $request->watched;
            if (!$request->watched) {

                return response()->json([
                    'message' => 'You need to finish the lesson.',
                ]);
            }
            if ($lessonUSer->save()) {
               
                dispatch(new LessonWatched($lessonUSer->lesson, $lessonUSer->user));
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
