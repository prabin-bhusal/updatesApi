<?php

namespace App\Repositories;

use App\Filters\V1\NewsFilter;
use App\Models\Comment;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentRepository implements CommentRepositoryInterface
{
    public function getAllComment()
    {
        $comment = Comment::all();
        $comment->loadMissing('user');
        return $comment->loadMissing('news');
    }

    public function storeComment(Request $request)
    {
        $formdata = [
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
            'news_id' => (int)$request->newsId,
            'parent_id' => (int)$request->parentId
        ];
        $data = Comment::create($formdata);
        $data->loadMissing('user');
        return $data->loadMissing('news');
    }

    public function updateComment(Request $request, Comment $comment)
    {

        $result = $comment->update([
            'comment' => $request->comment
        ]);


        return $comment;
    }

    public function deleteComment(Comment $comment)
    {
        try {
            $comment->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
