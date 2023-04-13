<?php

namespace App\Services\Dashboard;

use App\Exceptions\UnauthorizedException;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class DashboardService {



    /**
     * @throws NotFound
     */
    public static function getNumPostsEachUser()
    {
        return User::withCount('posts')->get();
    }

    public static function getNumCommentsEachUser()
    {
        return User::select('users.*', \DB::raw('count(comments.id) as comment_count'))
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->whereNull('users.deleted_at')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.password', 'users.created_at', 'users.updated_at', 'users.deleted_at','users.role')
            ->get();

//        return User::with(['posts' => function ($query) {
//            $query->withCount('comments');
//        }])->get();
    }

    public static function top5Users()
    {
        return User::select('users.*', \DB::raw('count(comments.id) as comment_count'))
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->whereNull('users.deleted_at')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.password', 'users.created_at', 'users.updated_at', 'users.deleted_at','users.role')
            ->orderByDesc('comment_count')
            ->limit(5)
            ->get();

    }

    public static function top5commentedPosts(){
        return Post::withCount('comments')->with('user')->with(['tags' => function ($query) {
            $query->with('tag');
        }])->orderByDesc('comments_count')
            ->take(5)
            ->get();
    }

    public static function commonTags(){
        return Tag::withCount('tags')->orderByDesc('tags_count')->take(5)->get();
    }

    public static function postsWithMostTags(){
        return Post::withCount('tags')
            ->orderBy('tags_count', 'desc')
            ->take(5)
            ->get();
    }

    public static function userZeroComments(){
        return User::leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->whereNull('comments.id')
            ->whereNull('users.deleted_at')
            ->select('users.*')
            ->get();

    }
}
