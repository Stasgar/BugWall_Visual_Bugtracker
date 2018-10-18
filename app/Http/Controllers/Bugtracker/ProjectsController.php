<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Controllers\BugtrackerBaseController;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Repositories\ProjectRepository;
use App\Project;
use function Aws\recursive_dir_iterator;
use Illuminate\Http\Request;

class ProjectsController extends BugtrackerBaseController
{

    protected $project_repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->project_repository = $repository;
    }

    /*
     * Show all projects
    */
    public function getAllProjects()
    {
        $projects = $this->project_repository->all();
        
        return view('bugtracker.projects', compact('projects'));

    }

    /*
     * Show projects, which current user can access
    */
    public function getAvailableProjects()
    {
        $projects = auth()->user()->projects;
        $projects->load('issues','boards', 'members');

        return view('bugtracker.projects', ['projects'=>$projects]);
    }

    /*
     * Get project by project index (id), and redirect to it's issues
    */
    public function getProjectById(Project $project)
    {
        return redirect()->route('project.issues', compact('project'));
    }

    /*
     * Create new project, and store it in DataBase
    */
    public function postCreateProject(CreateProjectRequest $request)
    {
        $newProject = $this->project_repository->create($request->all());

        if($request->ajax()) {
            return view('bugtracker.project-box', ['project' => $newProject])->render();
        }

        return redirect()->back();
    }


    /*
     * Delete existing project
    */
    public function postDeleteProject(Request $request, Project $project)
    {
        $this->project_repository->delete($project, auth()->user());

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    /**
     * Renders project settings page.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSettingsPage(Request $request, Project $project)
    {
        return view('bugtracker.project.settings', compact('project'));
    }

    /**
     * Updates project properties.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateProject(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return redirect()->back();
    }

}
