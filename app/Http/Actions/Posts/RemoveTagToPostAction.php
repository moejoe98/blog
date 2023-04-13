<?php

namespace App\Http\Actions\Posts;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Services\Posts\PostsService;
use App\Services\PostsTags\PostsTagsService;
use App\Services\Tags\TagsService;
use Tymon\JWTAuth\Facades\JWTAuth;


class RemoveTagToPostAction
{
    public function execute($userId, $tagId)
    {
        $postTag = PostsTagsService::getPostTagById($tagId);
        PostsService::checkIfPostForUser($postTag->post_id, $userId);
        return PostsTagsService::deletePostTagById($tagId);
    }
}
