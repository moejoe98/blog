<?php

namespace App\Http\Controllers;


use App\Exceptions\AlreadyExistsException;
use App\Http\Actions\Posts\AddTagToPostAction;
use App\Http\Actions\Posts\CreatePostAction;
use App\Http\Actions\Posts\DeletePostAction;
use App\Http\Actions\Posts\RemoveTagToPostAction;
use App\Http\Actions\Posts\UpdatePostAction;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Posts\AddTagToPostRequest;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\GetPostByTagRequest;
use App\Http\Requests\Posts\RemoveTagToPostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Services\Posts\PostsService;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Tymon\JWTAuth\Facades\JWTAuth;


class PostController extends Controller
{

    public function create(CreatePostRequest $request, CreatePostAction $action)
    {
        $userId = JWTAuth::user()->id;

        try {
        $data = $action->execute($request->content, $userId);
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function updatePost(UpdatePostRequest $request, UpdatePostAction $action)
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
            $data = PostsService::getPostById($postId);
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

    public function getPostByTag(GetPostByTagRequest $request)
    {

        try {
            $data = PostsService::getPostByTag($request->tag);
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

    public function addTagToPost(AddTagToPostRequest $request, AddTagToPostAction $action)
    {

        $userId = JWTAuth::user()->id;

        try {
            $data = $action->execute($userId, $request->post_id, $request->tag);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (NotFound $exception)
        {
            return $this->errorResponse(422, ('Not Found'));
        }
        catch (AlreadyExistsException $exception)
        {
            return $this->errorResponse(422, ('Tag Already Exists'));
        }
        catch (UnauthorizedException $exception)
        {
            return $this->errorResponse(422, ('Unauthorized'));
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function removeTag($tagId, RemoveTagToPostAction $action)
    {
        $userId = JWTAuth::user()->id;

        try {
            $data = $action->execute($userId, $tagId);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (NotFound $exception)
        {
            return $this->errorResponse(422, ('Not Found'));
        }
        catch (UnauthorizedException $exception)
        {
            return $this->errorResponse(422, ('Unauthorized'));
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
