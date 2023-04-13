<?php

namespace App\Http\Actions\Posts;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Services\Posts\PostsService;
use Tymon\JWTAuth\Facades\JWTAuth;


class UpdatePostAction
{
    public function execute($userId, $data)
    {
        PostsService::checkIfPostForUser($data['post_id'], $userId);
        return PostsService::updatePost($data);
    }
}
