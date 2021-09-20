<?php

namespace App\Http\Controllers\Api\V1\User;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\WorkspaceRequest;
use App\Http\Resources\Workspace as WorkspaceResource;
use App\Http\Resources\WorkspaceCollection;
use App\Models\Workspace;
use Illuminate\Support\Facades\Gate;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces=auth()->user()->workspaces()->latest()->get();
        return $this->respond(new WorkspaceCollection($workspaces));
    }

    public function store(WorkspaceRequest $request)
    {
        $user=auth()->user();
        $workspace=Workspace::create([
            'user_id'=>$user->id,
            'label'=>$request->label,
            'url'  =>$request->url,
            'description'=>$request->description
        ]);
        return $this->respond($workspace,'Created successfully');
    }

    public function show(Workspace $workspace)
    {
        if (!Gate::allows('user-workspace',$workspace)){
            return $this->respondNotAccess(ApiCode::NOT_ACCESS);
        }
        return $this->respond(new WorkspaceResource($workspace));
    }

    public function update(WorkspaceRequest $request, Workspace $workspace)
    {
        $user=auth()->user();
        if (!Gate::allows('user-workspace',$workspace)){
            return $this->respondNotAccess(ApiCode::NOT_ACCESS);
        }
        $workspace->update([
            'user_id'=>$user->id,
            'label'=>$request->label,
            'url'  =>$request->url,
            'description'=>$request->description
        ]);
        return $this->respond(new WorkspaceResource($workspace),'Updated successfully');
    }

    public function destroy(Workspace $workspace)
    {
        if (!Gate::allows('user-workspace',$workspace)){
            return $this->respondNotAccess(ApiCode::NOT_ACCESS);
        }
        $workspace->delete();
        return $this->respondWithMessage('Deleted successfully');
    }
}
