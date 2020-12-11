<?php

namespace App;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class tag extends Model
{
    protected $fillable = ['name' , 'admin_id'];

//    public function getRouteKeyName()
//    {
//        return 'name';
//    }

    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    public function admin(){
        return $this->belongsTo(User::class);
    }

    private static $delimeters = [' ' , ','];

    public static function delimeters($request){
        foreach (self::$delimeters as $delimeter){
            if (strpos($request , $delimeter)){
                $delimeters[] = $delimeter ;
            }
        }
        return $delimeters ?? NULL;
    }

    public static function asginTags($new , $user_id = null){
        $tags = new self();
        if (self::delimeters($new) !== null){
            $inserted_tags = preg_split('/( |,)/' , $new);
            $counter = 0 ;
            foreach ($inserted_tags as $tag){
                if ($tags->whereName(str_slug($tag))->exists() ){
                    $userTags[] = tag::whereName($tag)->get();
                    continue ;
                }

                $tags->create(['name' => str_slug($tag) , 'admin_id' => Sentinel::getUser()->id]);
                $userTags[] = tag::whereName($tag)->get();
                ++$counter;
            }
        }else{
            if (!$tags->whereName(str_slug($new))->exists()){
                $tags->create(['name' => str_slug($new) , 'admin_id' => Sentinel::getUser()->id]);
            }
            $userTags = $tags->whereName(str_slug($new))->first();
        }
        Session::put('tags' , $userTags);
        return true;
    }

    public static function popularTags(){
        return static::join('post_tag' , 'post_tag.tag_id' , '=' , 'tags.id')
            ->groupBy(['tags.id' , 'tags.name'])
            ->get(['tags.id' , 'tags.name' , DB::raw('count(tags.id) as tag_count')])
            ->sortByDesc('tag_count')->take(3);
    }


}
