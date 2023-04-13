<?php

namespace App\Http\Actions\Comments;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Services\Comments\CommentsService;
use Tymon\JWTAuth\Facades\JWTAuth;


class DeleteCommentAction
{
    public function execute($commentId)
    {
        return CommentsService::deleteCommentById($commentId);
    }
}
