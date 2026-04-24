<?php

namespace App\Trait;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function generateSlug(string $name, string $column='slug'): string{
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while(static::where('slug', $slug)->exists()){
            $slug = $original . '-' . $i;
            $i++;   
        }
        return $slug;
    }
}
