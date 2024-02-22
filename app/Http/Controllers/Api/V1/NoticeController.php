<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NoticeCollection;
use App\Http\Resources\V1\NoticeResource;
use App\Repositories\NoticeRepositoryInterface;

class NoticeController extends Controller
{
    private $noticeRepository;
    public function __construct(NoticeRepositoryInterface $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notices = $this->noticeRepository->getAllNotices($request);
        return new NoticeCollection($notices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoticeRequest $request)
    {
        $notice = $this->noticeRepository->storeNotice($request);
        return new NoticeResource($notice);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        return new NoticeResource($notice->loadMissing('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoticeRequest $request, Notice $notice)
    {
        $updatedNotice = $this->noticeRepository->updateNotice($request, $notice);
        return new NoticeResource($updatedNotice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        return $this->noticeRepository->destroyNotice($notice);
    }
}
