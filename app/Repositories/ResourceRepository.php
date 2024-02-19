<?php

namespace App\Repositories;

use App\Models\News;
use App\Models\Resource;
use App\Repositories\ResourceRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function getAllResources(Request $request)
    {
        $includeUser = $request->query('includeUser'); // ?includeUser=true

        $resource = Resource::paginate(5);

        // if ($includeUser) {
        //     $resource = $resource->with('user')->get();
        // }

        return $resource;
    }

    public function storeResource(Request $request)
    {
        $file = $request->file('resourceFile');
        $filename = uniqid() . "_" . $file->getClientOriginalName();
        $file->move(public_path('public/files'), $filename);
        $url = $filename;
        $formdata = [
            'title' => $request->title,
            'content' => $request->content,
            'resource_file' => $url,
            'user_id' => auth('sanctum')->user()->id
        ];
        $data = News::create($formdata);
        return $data;
    }


    public function showResource(Resource $resource)
    {
        $includeUser = request()->query('includeUser'); // ?includeUser=true

        if ($includeUser) {
            return $resource->loadMissing('user');
        }

        return $resource;
    }

    public function updateResource(Request $request, Resource $resource)
    {
        return $resource->update($request->all());
    }

    public function deleteResource(Resource $resource)
    {
        try {
            $resource->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
