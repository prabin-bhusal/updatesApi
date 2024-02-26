<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\V1\CommentCollection;
use App\Http\Resources\V1\CommentResource;
use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;
use Exception;

class CommentController extends Controller
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    public function index()
    {
        $comment = $this->commentRepository->getAllComment();

        return new CommentCollection($comment);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {

        try {
            $data = $this->commentRepository->storeComment($request);

            return response()->json([
                'message' => "Successfully created",
                'data' => new CommentResource($data)

            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Something went wrong",
                'error' => $e->getMessage()

            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'message' => 'ok'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = $this->commentRepository->updateComment($request, $comment);

        if ($data) {
            return response()->json([
                'message' => "Successfully updated",
                'data' => new CommentResource($data)

            ], 200);
        } else {
            return response()->json([
                'message' => "Something went wrong",
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        try {
            $deleted = $this->commentRepository->deleteComment($comment);

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
                'error' => $exception->getMessage()

            ], 404);
        }
    }
}
