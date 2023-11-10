<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::select('id', 'type_id', 'title', 'url', 'content', 'slug', )
            ->with('type:id,label,color', 'technologies:id,label,color')
            ->paginate(12);

        return response()->json(["projects" => $project]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::select('id', 'type_id', 'title', 'url', 'content', 'slug', )
            ->where('id', $id)
            ->with('type:id,label,color', 'technologies:id,label,color')
            ->firstOrFail();

        return response()->json($project);
    }

    public function portfolioFilterType($type_id)
    {
        $type = Type::select('id', 'label', 'color')
            ->where('id', $type_id)
            ->first();

        if (!$type)
            abort(404, 'Nessuna tipologia trovata');


        $projects = Project::select('id', 'type_id', 'title', 'url', 'content', 'slug', )
            ->where('type_id', $type_id)
            ->with('type:id,label,color', 'technologies:id,label,color')
            ->orderByDesc('id')
            ->paginate(12);

        return response()->json(["type" => $type, "projects" => $projects,]);
    }
}