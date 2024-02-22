<?php

namespace App\Repositories;

interface NoticeRepositoryInterface
{
    public function getAllNotices($request);
    public function storeNotice($request);
    public function updateNotice($request, $notice);
    public function destroyNotice($notice);
}