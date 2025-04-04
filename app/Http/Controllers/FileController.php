<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        
        $files = $project->files()->with('uploader')->get();
        
        return view('files.index', compact('project', 'files'));
    }

    public function upload(Request $request, Project $project, Task $task = null)
    {
        $this->authorize('update', $project);
        
        // Ensure task belongs to this project if provided
        if ($task && $task->project_id !== $project->id) {
            abort(404);
        }
        
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = $uploadedFile->getClientOriginalName();
            $filepath = $uploadedFile->store('project-files', 'public');
            
            $file = new File([
                'filename' => $filename,
                'filepath' => $filepath,
                'filetype' => $uploadedFile->getClientMimeType(),
                'filesize' => $uploadedFile->getSize(),
                'project_id' => $project->id,
                'uploaded_by' => Auth::id(),
                'task_id' => $task ? $task->id : null,
            ]);
            
            $file->save();

            $redirectRoute = $task 
                ? route('projects.tasks.show', [$project, $task]) 
                : route('projects.files.index', $project);
            
            return redirect($redirectRoute)
                ->with('success', 'File uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload file.');
    }

    public function download(Project $project, File $file)
    {
        $this->authorize('view', $project);
        
        // Ensure file belongs to this project
        if ($file->project_id !== $project->id) {
            abort(404);
        }
        
        if (Storage::disk('public')->exists($file->filepath)) {
            return Storage::disk('public')->download(
                $file->filepath, 
                $file->filename
            );
        }

        return back()->with('error', 'File not found.');
    }

    public function destroy(Project $project, File $file)
    {
        $this->authorize('update', $project);
        
        // Ensure file belongs to this project
        if ($file->project_id !== $project->id) {
            abort(404);
        }
        
        if (Storage::disk('public')->exists($file->filepath)) {
            Storage::disk('public')->delete($file->filepath);
        }
        
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
