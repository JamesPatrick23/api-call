<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Display all students.
     */
    public function index(): JsonResponse
    {
        $students = Student::all();

        return response()->json([
            'message' => 'Students fetched successfully',
            'data' => $students
        ], 200);
    }

    /**
     * Display one student by ID.
     */
    public function show($id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Student successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Store a new student.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    /**
     * Fully update a student.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'course' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Partially update a student.
     */
    public function patch(Request $request, $id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'course' => 'sometimes|string|max:255',
            'age' => 'sometimes|integer|min:1',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student partially updated successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Delete one student.
     */
    public function destroy($id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }

    /**
     * Delete all students.
     */
    public function destroyAll(): JsonResponse
    {
        Student::truncate();

        return response()->json([
            'message' => 'All students deleted successfully'
        ], 200);
    }
}