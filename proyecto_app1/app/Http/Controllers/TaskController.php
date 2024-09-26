<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request; // Asegúrate de importar Request
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Inyecta Request aquí
    {
        $query = Task::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");

        if ($request->input("name")) {
            $query->where("name", "like", "%" . $request->input("name") . "%");
        }
        if ($request->input("status")) {
            $query->where("status", $request->input("status"));
        }

        $tasks = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render("Task/Index", [
            "tasks" => TaskResource::collection($tasks),
            'queryParams' => $request->query() ?: null,
            'success' => session('success'),
        ]);
    }

    // Otros métodos del controlador permanecen iguales, excepto donde se necesita request()

    public function myTasks(Request $request) // Inyecta Request aquí
    {
        $user = auth()->user();
        $query = Task::query()->where('assigned_user_id', $user->id);

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");

        if ($request->input("name")) {
            $query->where("name", "like", "%" . $request->input("name") . "%");
        }
        if ($request->input("status")) {
            $query->where("status", $request->input("status"));
        }

        $tasks = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render("Task/Index", [
            "tasks" => TaskResource::collection($tasks),
            'queryParams' => $request->query() ?: null,
            'success' => session('success'),
        ]);
    }
}
