<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\V1\ResourceCollection;
use App\Models\Resource;
use App\Repositories\ResourceRepositoryInterface;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
