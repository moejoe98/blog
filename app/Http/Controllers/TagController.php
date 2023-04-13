<?php

namespace App\Http\Controllers;


use App\Http\Actions\Posts\CreatePostAction;
use App\Http\Actions\Posts\DeletePostAction;
use App\Http\Actions\Posts\UpdatePostAction;
use App\Http\Controllers\Controller;
use App\Exceptions\WrongCredentialsException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Posts\CreateCommentRequest;
use App\Http\Requests\Posts\UpdateCommentRequest;
use App\Http\Requests\Tags\SearchTagRequest;
use App\Services\Posts\CommentsService;
use App\Services\Tags\TagsService;
use http\Env\Request;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Tymon\JWTAuth\Facades\JWTAuth;


class TagController extends Controller
{

    public function searchByName(SearchTagRequest $request)
    {
        try {
        $data = TagsService::searchTagByName($request->tag);
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

    public function updatePost(UpdateCommentRequest $request, UpdatePostAction $action)
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

    public function getPostById($postId)
    {
        try {
            $data = CommentsService::getPostById($postId);
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

    public function deletePostById($postId, DeletePostAction $action){
        try {
            $data = $action->execute($postId);
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
