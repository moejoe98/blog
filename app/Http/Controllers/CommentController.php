<?php

namespace App\Http\Controllers;


use App\Http\Actions\Comments\CreateCommentAction;
use App\Http\Actions\Comments\DeleteCommentAction;
use App\Http\Actions\Comments\UpdateCommentAction;
use App\Http\Actions\Posts\DeletePostAction;
use App\Http\Actions\Posts\UpdatePostAction;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CreateCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Services\Comments\CommentsService;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Tymon\JWTAuth\Facades\JWTAuth;


class CommentController extends Controller
{

    public function create(CreateCommentRequest $request, CreateCommentAction $action)
    {
        $userId = JWTAuth::user()->id;

        try {
            $data = $action->execute($request->getDataObject(), $userId);
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function updateComment(UpdateCommentRequest $request, UpdateCommentAction $action)
    {
        $userId = JWTAuth::user()->id;
        try {
            $data = $action->execute($userId, $request->getData());
            return $this->successResponse(true, 'Success', $data);
        }
        catch (UnauthorizedException $exception)
        {
            return $this->errorResponse(422, ('Unauthorized'));
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function getCommentById($commentId)
    {
        try {
            $data = CommentsService::getCommentById($commentId);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (NotFound $exception)
        {
            return $this->errorResponse(422, ('Not Found'));
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function deleteCommentById($commentId, DeleteCommentAction $action){
        try {
            $data = $action->execute($commentId);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (NotFound $exception)
        {
            return $this->errorResponse(422, ('Not Found'));
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }
    }
}
