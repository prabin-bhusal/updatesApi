<?php

namespace App\Repositories;

use App\Models\Notice;
use App\Filters\V1\NoticeFilter;
use App\Repositories\NoticeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NoticeRepository implements NoticeRepositoryInterface
{
    public function getAllNotices($request)
    {
        $filter = new NoticeFilter();
        $queryItems = $filter->transform($request);

        $includeUserData = $request->query('includeUser');

        $notices = Notice::where($queryItems);

        if ($includeUserData) {
            $notices = $notices->with('user');
        }

        return $notices->paginate()->appends($request->query());
    }

    public function storeNotice($request)
    {
        $notice = DB::transaction(function () use ($request) {
            if ($request->has('banner')) {
                $file = $request->file('banner');
                $banner_filename = $this->storeMedia($file, 'banner');
            }

            if ($request->has('attached_file')) {
                $file = $request->attached_file;
                $attached_file_filename = $this->storeMedia($file, 'attached_file');
            }

            $params = [
                'title' => $request->title,
                'content' => $request->content,
                'banner' => $banner_filename,
                'attached_file' => $attached_file_filename,
                'date' => $request->date,
                'user_id' => auth('sanctum')->user()->id
            ];

            return Notice::create($params);
        });
        return $notice;
    }

    public function updateNotice($request, $notice)
    {
        $updatedNotice = DB::transaction(function () use ($request, $notice) {
            $params = [
                'title' => $request->title,
                'content' => $request->content,
                'date' => $request->date,
            ];
            if ($request->has('banner')) {
                $file = $request->file('banner');
                $banner_filename = $this->storeMedia($file, 'banner');

                Storage::delete("public/images/" . $notice->banner);
                $params['banner'] = $banner_filename;
            }

            if ($request->has('attached_file')) {
                $file = $request->attached_file;
                $attached_file_filename = $this->storeMedia($file, 'attached_file');

                Storage::delete("public/files/" . $notice->attached_file);
                $params['attached_file'] = $attached_file_filename;
            }

            return $notice->update($params);
        });
        return $updatedNotice;
    }

    public function destroyNotice($notice)
    {
        Storage::delete("public/images/" . $notice->banner);
        Storage::delete("public/files/" . $notice->attached_file);
        return $notice->delete();
    }

    private function storeMedia($file, $mediaType)
    {
        $name = $file->getClientOriginalName();
        $name = substr($name, 0, strpos($name, '.'));
        $extension = $file->getClientOriginalExtension();
        $filename = $name . time() . '.' . $extension;
        if ($mediaType == 'banner') {
            $path = public_path("storage/") . "images/";
        } else if ($mediaType == 'attached_file') {
            $path = public_path("storage/") . "attached_files/";
        }
        $file->move($path, $filename);
        return $filename;
    }
}
