<?php

namespace App\Services\PostsTags;

use App\Models\Post;
use App\Exceptions\AlreadyExistsException;
use App\Models\PostTags;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class PostsTagsService {


    public static function create($postId, $tag)
    {
        return PostTags::create([
            'post_id' => $postId,
            'tag_id' => $tag,
        ]);
    }

    public static function deletePostTagById($tagId)
    {
        $tag = PostTags::find($tagId);
        if (isset($tag))
            return $tag->delete();
        else throw new NotFound();
    }


    public static function checkTagExist($postId, $tagId) {
        $check = PostTags::where(['post_id' => $postId, 'tag_id' => $tagId])->first();
        if(!$check){
            return true;
        }
            else throw new AlreadyExistsException();
    }

      public static function getPostTagById($tagId) {
        $check = PostTags::find($tagId);
        if($check){
            return $check;
        }
            else throw new NotFound();
    }


}
