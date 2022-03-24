<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Events\LessonWatched;
use App\Listeners\ListenLessonWatched;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Event;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }

    public function test_event_despatched()
    {

        Event::fake([
            ListenLessonWatched::class
        ]);

        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        Event::assertDispatched(LessonWatched::class, function ($e) use ($lesson, $user) {
            return $e->lesson_id === $lesson->id && $e->user_id == $user->id;
        });
    }
}
