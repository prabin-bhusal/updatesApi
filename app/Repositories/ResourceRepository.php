<?php

namespace App\Repositories;

use App\Models\News;
use App\Models\Resource;
use App\Repositories\ResourceRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        if ($request->has('resourceFile')) {
            $file = $request->file('resourceFile');
            $name = $file->getClientOriginalName();
            $name = substr($name, 0, strpos($name, '.'));
            $extension = $file->getClientOriginalExtension();
            $filename = $name . time() . '.' . $extension;
            $path = public_path("storage/") . "files/";
            $file->move($path, $filename);
        }
        $formdata = [
            'title' => $request->title,
            'content' => $request->content,
            'resource_file' => $filename,
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
        if ($request->hasFile('resourceFile')) {
            $file = $request->file('resourceFile');
            $name = $file->getClientOriginalName();
            $name = substr($name, 0, strpos($name, '.'));
            $extension = $file->getClientOriginalExtension();
            $filename = $name . time() . '.' . $extension;
            $path = public_path("storage/") . "files/";
            $file->move($path, $filename);
            Storage::delete("public/files/" . $resource->resource_file);

            $resource->update([
                'title' => $request->title,
                'content' => $request->content,
                'resource_file' => $filename,
            ]);
        } else {
            $resource->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }
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
