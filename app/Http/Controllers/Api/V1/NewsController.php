<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\NewsFilter;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NewsCollection;
use App\Http\Resources\V1\NewsResource;
use App\Repositories\NewsRepositoryInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * News Repository setup and construction
     */
    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }


    /**
     * Get All News 
     * /api/v1/news (if logged in)
     * /api/v1/test (for testing purpose)
     */
    public function index(Request $request)
    {

        $news = $this->newsRepository->getAllNews($request);

        return new NewsCollection($news->paginate()->appends($request->query()));
    }


    /**
     * Store a newly created resource in storage.
     * TODO: image upload left to do
     * URL: /api/v1/news
     * Method: POST
     * Body: title, slug, content, banner_image, status
     */
    public function store(StoreNewsRequest $request)
    {

        $data = $this->newsRepository->storeNews($request);

        if ($data) {
            return response()->json([
                'message' => "Successfully created",
                'data' => new NewsResource($data)

            ], 201);
        }
    }

    /**
     * Display the specified resource.
     * URL: /api/v1/news/{id}
     */
    public function show(News $news)
    {
        $data = $this->newsRepository->showNews($news);

        return new NewsResource($data);
    }


    /**
     * Update the specified resource in storage.
     * METHOD: PUT/PATCH
     * URL: /api/v1/news
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $data = $this->newsRepository->updateNews($request, $news);

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
     * URL: /api/v1/news
     * METHOD: DELETE
     */
    public function destroy(News $news)
    {
        // dd($news);
        try {
            $deleted = $this->newsRepository->deleteNews($news);

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
