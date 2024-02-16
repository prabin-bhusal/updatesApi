<?php

namespace App\Repositories;

use App\Filters\V1\NewsFilter;
use App\Models\News;
use App\Repositories\NewsRepositoryInterface;
use Illuminate\Http\Request;

class NewsRepository implements NewsRepositoryInterface
{
    public function getAllNews(Request $request)
    {
        // $user = auth('sanctum')->user();

        $filter = new NewsFilter();
        $filterItems = $filter->transform($request); //[['column','operator','value']]

        $includeUser = $request->query('includeUser'); // ?includeUser=true

        $news = News::where($filterItems);

        if ($includeUser) {
            $news = $news->with('user');
        }

        return $news;
    }

    public function storeNews(Request $request)
    {
        $formdata = [
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'banner_image' => $request->banner_image,
            'status' => $request->status,
            'user_id' => auth('sanctum')->user()->id
        ];
        $data = News::create($formdata);
        return $data;
    }


    public function showNews(News $news)
    {
        $includeUser = request()->query('includeUser'); // ?includeUser=true

        if ($includeUser) {
            return $news->loadMissing('user');
        }

        return $news;
    }

    public function updateNews(Request $request, News $news)
    {
        return $news->update($request->all());
    }

    public function deleteNews(News $news)
    {
        $user = auth('sanctum')->user();
        if ($news->user_id == $user->id) {
            $news->delete();
            return true;
        }

        return false;
    }
}
