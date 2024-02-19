<?php

namespace App\Repositories;

use App\Filters\V1\NewsFilter;
use App\Models\News;
use App\Repositories\NewsRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        if ($request->has('bannerImage')) {
            $file = $request->file('bannerImage');
            $name = $file->getClientOriginalName();
            $name = substr($name, 0, strpos($name, '.'));
            $extension = $file->getClientOriginalExtension();
            $filename = $name . time() . '.' . $extension;
            // $path = public_path("storage/") . "images/";
            // $file->move($path, $filename);

            Storage::disk('public')->put('images', $file);
        }
        $formdata = [
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'banner_image' => $filename,
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
        if ($request->hasFile('bannerImage')) {
            $file = $request->file('bannerImage');
            $name = $file->getClientOriginalName();
            $name = substr($name, 0, strpos($name, '.'));
            $extension = $file->getClientOriginalExtension();
            $filename = $name . time() . '.' . $extension;
            $path = public_path("storage/") . "images/";
            $file->move($path, $filename);
            Storage::delete("public/images/" . $news->banner_image);

            $news->update([
                'title' => $request->title,
                'content' => $request->content,
                'banner_image' => $filename,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
        } else {
            $news->update([
                'title' => $request->title,
                'content' => $request->content,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
        }
        return $news->update($request->all());
    }

    public function deleteNews(News $news)
    {
        try {
            Storage::delete("public/images/" . $news->banner_image);
            $news->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}


// try {
//     Storage::delete("public/images/" . $news->banner_image);
//     News::destroy($news->id);
//     return "Success";
// } catch (Exception $E) {
//     return "Failed";
// }