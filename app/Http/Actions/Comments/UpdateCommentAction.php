<?php

namespace App\Http\Actions\Comments;

use App\Services\Comments\CommentsService;


class UpdateCommentAction
{
    public function execute($userId, $data)
    {
        CommentsService::checkIfCommentForUser($data['commentId'], $userId);
        $data['status'] = 'PENDING';
        return CommentsService::updateComment($data['commentId'], $data);
    }
}
