<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Requests\CourseRequest;
use App\Services\CourseService;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request, CourseService $courseService)
    {
        $validatedData = $request->validated();

        if ($courseService->isTimeSlotOccupied($validatedData['day'], $validatedData['hour_start'], $validatedData['hour_end'])){
            return response()->json(['message'=>'cette plage horaire est deja occupee']);
        }

        $course = Course::create($validatedData);
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course, CourseService $courseService )
    {
        $validatedData = $request->validated();

        if ($courseService->isTimeSlotOccupiedExcludingCourse(
            $validatedData['day'], 
            $validatedData['hour_start'], 
            $validatedData['hour_end'], 
            $course->id
        )){
            return response()->json(['message'=>'cette plage horaire est deja occupee']);

        }
        $course->day = $validatedData['day'];
        $course->day = $validatedData['hour_start'];
        $course->day = $validatedData['hour_end'];
        $course->user_id = $validatedData['user_id'];
        $course->subject_id = $validatedData['classroom_id'];
        $course->classroom_id = $validatedData['classroom_id'];
        $course->save();
        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message'=>'cours supprime avec succes']);
    }
}
