<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Http\Request;

interface NewsRepositoryInterface
{
    public function getAllNews(Request $request);

    public function storeNews(Request $request);

    public function showNews(News $news);

    public function updateNews(Request $request, News $news);

    public function deleteNews(News $news);
}
