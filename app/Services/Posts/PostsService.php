<?php

namespace App\Services\Posts;

use App\Models\Post;
use App\Exceptions\UnauthorizedException;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class PostsService {


    public static function create($content, $userId)
    {
        return Post::create([
            'user_id' => $userId,
            'content' => $content,
        ]);
    }


    /**
     * @throws NotFound
     */
    public static function getPostById($postId)
    {
        $data = Post::with('user')->with(['comments' => function ($query) {
            $query->where('status','APPROVED');
        }])->with(['tags' => function ($query) {
            $query->with('tag');
        }])->find($postId);
        if(!$data){
            throw new NotFound();
        }
        else return $data;
    }


    public static function updatePost($data)
    {
        return Post::updateOrCreate(['id' => $data['post_id']],$data);
    }

    public static function deletePostById($postId)
    {
        $post = Post::find($postId);
        if (isset($post))
            return $post->delete();
        else throw new NotFound();
    }

    public static function restorePostById($postId){
        $post = Post::withTrashed()->find($postId);
        if(isset($post))
        return $post->restore();
        else throw new NotFound();
    }

    public static function checkIfPostForUser($postId, $userId) {
        $check = Post::where(['id' => $postId, 'user_id' => $userId])->first();
        if($check){
            return true;
        }
            else throw new UnauthorizedException();
    }
}
