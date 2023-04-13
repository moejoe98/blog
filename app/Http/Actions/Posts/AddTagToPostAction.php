<?php

namespace App\Http\Actions\Posts;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Services\Posts\PostsService;
use App\Services\PostsTags\PostsTagsService;
use App\Services\Tags\TagsService;
use Tymon\JWTAuth\Facades\JWTAuth;


class AddTagToPostAction
{
    public function execute($userId, $postId, $tagCont)
    {
        PostsService::checkIfPostForUser($postId, $userId);
        $tag = TagsService::getTagByName($tagCont);
        if($tag){
            $tagId = $tag->id;
            PostsTagsService::checkTagExist($postId, $tagId);
        } else {
            $createTag = TagsService::create($tagCont);
            $tagId = $createTag->id;
        }
        return PostsTagsService::create($postId, $tagId);
    }
}
