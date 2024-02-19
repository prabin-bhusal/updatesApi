<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\V1\ResourceCollection;
use App\Http\Resources\V1\ResourceResource;
use App\Models\Resource;
use App\Repositories\ResourceRepositoryInterface;
use Exception;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    private ResourceRepositoryInterface $resourceRepository;

    public function __construct(ResourceRepositoryInterface $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new ResourceCollection($this->resourceRepository->getAllResources($request));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request)
    {
        if (!Gate::allows('isAdmin')) {
            abort(403, 'Not Authorized');
        }

        $data = $this->resourceRepository->storeResource($request);

        if ($data) {
            return response()->json([
                'message' => "Successfully created",
                'data' => new ResourceResource($data)

            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        $data = $this->resourceRepository->showResource($resource);

        return new ResourceResource($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        $data = $this->resourceRepository->updateResource($request, $resource);

        if ($data) {
            return response()->json([
                'message' => "Successfully updated",
            ], 200);
        } else {
            return response()->json([
                'message' => "Something went wrong"
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);
        try {
            $deleted = $this->resourceRepository->deleteResource($resource);

            if ($deleted) {
                return response()->json([
                    'message' => "Successfully deleted",

                ], 200);
            } else {
                return response()->json([
                    'message' => "You are not authorized to delete this",

                ], 401);
            }
        } catch (Exception $exception) {
            return response()->json([
                'message' => "No such data in database",
                'error' => $exception

            ], 404);
        }
    }
}
