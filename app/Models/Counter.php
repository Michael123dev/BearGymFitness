<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $guareded = ['id'];
    public $timestamps = false;

    public static function getCounter($section, $name, $format)
    {
        $counter = self::where('section', $section)
                    ->where('name', $name)
                    ->where('format', $format)
                    ->first();

        if (!$counter) 
        {
            $count              = 1;

            // auto detect placeholder {C:n}
            preg_match('/\{C:(\d+)\}/', $format, $matches);
            $padLength = $matches[1] ?? 3; // default 3 kalau tidak ketemu

            $formattedCounter   = str_replace(
                '{C:' . $padLength . '}',
                str_pad($count, $padLength, '0', STR_PAD_LEFT),
                $format
            );

            $counter = new self();
            $counter->section = $section;
            $counter->name = $name;
            $counter->format = $format;
            $counter->counter = $count;
            $counter->last_counter = $formattedCounter;
            $counter->created_at = Carbon::now();
            $counter->created_by = 1;
            $counter->updated_at = Carbon::now();
            $counter->updated_by = 1;
            $counter->save();
        } 
        else 
        {
            $count              = $counter->counter + 1;

            preg_match('/\{C:(\d+)\}/', $format, $matches);
            $padLength = $matches[1] ?? 3;

            $formattedCounter   = str_replace(
                '{C:' . $padLength . '}',
                str_pad($count, $padLength, '0', STR_PAD_LEFT),
                $format
            );

            $counter->counter = $count;
            $counter->last_counter = $formattedCounter;
            $counter->updated_at = Carbon::now();
            $counter->updated_by = 1;
            $counter->save();
        }

        return $formattedCounter;
    }

}
