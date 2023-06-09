<?php

namespace App\Http\Controllers;


use App\Exceptions\AlreadyExistsException;
use App\Http\Actions\Posts\AddTagToPostAction;
use App\Http\Actions\Posts\CreatePostAction;
use App\Http\Actions\Posts\DeletePostAction;
use App\Http\Actions\Posts\RemoveTagToPostAction;
use App\Http\Actions\Posts\UpdatePostAction;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Requests\Posts\AddTagToPostRequest;
use App\Http\Requests\Comments\ApproveCommentRequest;


use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Services\Dashboard\DashboardService;
use App\Services\Posts\PostsService;
use App\Services\Comments\CommentsService;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Tymon\JWTAuth\Facades\JWTAuth;


class DashboardController extends Controller
{


    public function getNumPostsEachUser()
    {

        try {
            $data = DashboardService::getNumPostsEachUser();
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function getNumCommentsEachUser()
    {

        try {
            $data = DashboardService::getNumCommentsEachUser();
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function top5CommentedUsers()
    {

        try {
            $data = DashboardService::top5Users();
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function top5commentedPosts()
    {

        try {
            $data = DashboardService::top5commentedPosts();
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }
    public function commonTags()
    {

        try {
            $data = DashboardService::commonTags();
            return $this->successResponse(true, 'Success', $data);
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function postsWithMostTags()
    {
        try {
            $data = DashboardService::postsWithMostTags();
            return $this->successResponse(true, 'Success', $data);
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function userZeroComments()
    {
        try {
            $data = DashboardService::userZeroComments();
            return $this->successResponse(true, 'Success', $data);
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function approveComment(ApproveCommentRequest $request)
    {
        try {
            $data = CommentsService::updateComment($request->commentId, ['status' => 'APPROVED']);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function deleteComment($commentId)
    {
        try {
            $data = CommentsService::deleteCommentById($commentId);
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

    public function updateComment(UpdateCommentRequest $request)
    {
        try {
            $data = CommentsService::updateComment($request->commentId, $request->getData());
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
