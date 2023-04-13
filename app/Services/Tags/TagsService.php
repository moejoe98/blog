<?php

namespace App\Services\Tags;

use App\Exceptions\UnauthorizedException;
use App\Models\Tag;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class TagsService {


    public static function create($tag)
    {
        return Tag::create([
            'tag' => $tag,
        ]);
    }


    /**
     * @throws NotFound
     */
    public static function getTagByName($tag)
    {
        $data = Tag::where('tag' , 'like' , "%$tag%")->first();
        if(!$data){
            return false;
        }
        else return $data;
    }

    public static function searchTagByName($tag)
    {
        $data = Tag::where('tag' , 'like' , "%$tag%")->get();
        if(!$data){
            return false;
        }
        else return $data;
    }


}
