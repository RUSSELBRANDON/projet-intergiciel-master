<?php

namespace App\Services;
use App\Models\Course;


class CourseService
{
    public function isTimeSlotOccupied($day, $newStart, $newEnd)
    {
        return Course::where('day', $day)
            ->where('hour_start', '<', $newEnd)
            ->where('hour_end', '>', $newStart)
            ->exists();
    }

    public function isTimeSlotOccupiedExcludingCourse($day, $newStart, $newEnd, $excludeCourseId)
    {
        return Course::where('day', $day)
            ->where('id', '!=', $excludeCourseId)
            ->where('hour_start', '<', $newEnd)
            ->where('hour_end', '>', $newStart)
            ->exists();
    }
}
