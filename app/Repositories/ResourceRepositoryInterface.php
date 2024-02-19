<?php

namespace App\Repositories;

use App\Models\Resource;
use Illuminate\Http\Request;

interface ResourceRepositoryInterface
{
    public function getAllResources(Request $request);

    public function storeResource(Request $request);

    public function showResource(Resource $resource);

    public function updateResource(Request $request, Resource $resource);

    public function deleteResource(Resource $resource);
}
