<?php

namespace App\Http\Actions\Posts;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Services\Posts\PostsService;
use Tymon\JWTAuth\Facades\JWTAuth;


class DeletePostAction
{
    public function execute($commentId)
    {
        return PostsService::deletePostById($commentId);
    }
}
