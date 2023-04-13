<?php

namespace App\Http\Actions\Comments;

use App\Services\Comments\CommentsService;


class CreateCommentAction
{
    public function execute($data, $userId)
    {
        return CommentsService::create($data->postId, $data->content, $userId);
    }
}
