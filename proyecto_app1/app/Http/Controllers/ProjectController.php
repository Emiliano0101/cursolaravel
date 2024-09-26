<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request; // Importar Request
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Inyectar Request aquí
    {
        $query = Project::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");

        if ($request->input("name")) {
            $query->where("name", "like", "%" . $request->input("name") . "%");
        }
        if ($request->input("status")) {
            $query->where("status", $request->input("status"));
        }

        $projects = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render("Project/Index", [
            "projects" => ProjectResource::collection($projects),
            'queryParams' => $request->query() ?: null,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Project/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        /** @var $image \Illuminate\Http\UploadedFile */
        $image = $data['image'] ?? null;
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        if ($image) {
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }
        Project::create($data);

        return to_route('project.index')
            ->with('success', 'Project was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request) // Inyectar Request aquí
    {
        $query = $project->tasks();

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

        return Inertia::render('Project/Show', [
            'project' => new ProjectResource($project),
            "tasks" => TaskResource::collection($tasks),
            'queryParams' => $request->query() ?: null,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => new ProjectResource($project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $data['updated_by'] = Auth::id();
        if ($image) {
            if ($project->image_path) {
                Storage::disk('public')->deleteDirectory(dirname($project->image_path));
            }
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }
        $project->update($data);

        return to_route('project.index')
            ->with('success', "Project \"$project->name\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $name = $project->name;
        $project->delete();
        if ($project->image_path) {
            Storage::disk('public')->deleteDirectory(dirname($project->image_path));
        }
        return to_route('project.index')
            ->with('success', "Project \"$name\" was deleted");
    }
}
