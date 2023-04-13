<?php

namespace App\Http\Actions\Posts;

use App\Services\Posts\PostsService;


class CreatePostAction
{
    public function execute($content, $userId)
    {
        return PostsService::create($content, $userId);
    }
}
