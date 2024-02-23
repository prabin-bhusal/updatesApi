<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;

interface CommentRepositoryInterface
{
    public function getAllComment();

    public function storeComment(Request $request);

    public function updateComment(Request $request, Comment $comment);

    public function deleteComment(Comment $comment);
}
