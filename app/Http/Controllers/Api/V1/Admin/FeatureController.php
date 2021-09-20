<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeatureRequest;
use App\Http\Resources\FeatureCollection;
use App\Models\Feature;
use App\Http\Resources\Feature as FeatureResource;

class FeatureController extends Controller
{
    public function index()
    {
        $features=Feature::latest()->paginate(10);
        return new FeatureCollection($features);
    }

    protected function store(FeatureRequest $request)
    {
        $feature = Feature::create([
            'label' =>$request->label,
            'tag' =>$request->tag,
            'cost' =>$request->cost,
        ]);
        return response()->json(['message'=>'Feature Created','data'=> $feature],201);
    }

    public function show(Feature $feature)
    {
        return new FeatureResource($feature);
    }

    protected function update(FeatureRequest $request, Feature $feature)
    {
        $feature->update([
            'tag' =>$request->tag,
            'label' =>$request->label,
            'cost' =>$request->cost,
        ]);
        return response()->json(['message'=>'Feature Updated','data'=> $feature],200);
    }

    protected function destroy(Feature $feature)
    {
        $feature->delete();
        return response()->json(['message'=>'Feature Deleted'],200);
    }

    protected function enable(Feature $feature)
    {
        if(!$feature->enable){
            $feature->update(array('enable'=>true));
            return response()->json(['message'=>'Feature Enabled'],200);
        }
        else{
            $feature->update(array('enable'=>false));
            return response()->json(['message'=>'Feature Disabled'],200);
        }
    }
}
