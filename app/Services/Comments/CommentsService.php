<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Exceptions\UnauthorizedException;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class CommentsService {

    public static function create($postId, $content, $userId)
    {
        return Comment::create([
            'user_id' => $userId,
            'post_id' => $postId,
            'content' => $content,
        ]);
    }


    /**
     * @throws NotFound
     */
    public static function getCommentById($postId)
    {
        $data = Comment::with('user','post')->find($postId);
        if(!$data){
            throw new NotFound();
        }
        else return $data;
    }


    public static function updateComment($commentId, $data)
    {
        return Comment::updateOrCreate(['id' => $commentId],['content' => $data['content']]);
    }

    public static function deleteCommentById($postId)
    {
        $post = Comment::find($postId);
        if (isset($post))
            return $post->delete();
        else throw new NotFound();
    }

    public static function restoreCommentById($postId){
        $post = Comment::withTrashed()->find($postId);
        if(isset($post))
        return $post->restore();
        else throw new NotFound();
    }

    public static function checkIfCommentForUser($commentId, $userId) {
        $check = Comment::where(['id' => $commentId, 'user_id' => $userId])->first();
        if($check){
            return true;
        }
            else throw new UnauthorizedException();
    }
}
