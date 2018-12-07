<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function pastes()
    {
        return $this->belongsToMany('App\Paste')->withTimestamps();
    }

    public static function getForCheckboxes()
    {
        $tags = self::orderBy('name')->get();

        $tagsForCheckboxes = [];

        foreach ($tags as $tag) {
            $tagsForCheckboxes[$tag['id']] = $tag->name;
        }

        return $tagsForCheckboxes;
    }
}
