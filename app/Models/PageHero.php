<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageHero extends Model
{
    protected $fillable = [
        'page_key',
        'name',
        'image',
        'video',
        'position',
    ];

    /**
     * Cached lookup of all page-hero rows keyed by page_key.
     */
    protected static $cache = null;

    protected static function rows()
    {
        if (static::$cache === null) {
            try {
                static::$cache = static::get(['page_key', 'image', 'video', 'position'])
                    ->keyBy('page_key')
                    ->toArray();
            } catch (\Throwable $e) {
                static::$cache = [];
            }
        }
        return static::$cache;
    }

    /**
     * Public URL of the background image for a page, or null.
     */
    public static function url($key)
    {
        $row = static::rows()[$key] ?? null;
        $image = $row['image'] ?? null;
        return $image ? '/images/page-heroes/' . $image : null;
    }

    /**
     * Public URL of the background video for a page, or null.
     */
    public static function video($key)
    {
        $row = static::rows()[$key] ?? null;
        $video = $row['video'] ?? null;
        return $video ? '/images/page-heroes/' . $video : null;
    }

    /**
     * Map an admin position keyword to a CSS background-position value.
     */
    public static function cssPosition($pos)
    {
        switch ($pos) {
            case 'top':    return 'center top';
            case 'bottom': return 'center bottom';
            default:       return 'center center';
        }
    }

    /**
     * Ready-to-use inline style attribute for the .page-hero section,
     * or an empty string when no image is set.
     *
     * Usage in blade:  <section class="page-hero" {!! \App\Models\PageHero::style('history') !!}>
     */
    public static function style($key)
    {
        $row = static::rows()[$key] ?? null;
        $image = $row['image'] ?? null;
        if (!$image) {
            return '';
        }
        $url = '/images/page-heroes/' . $image;
        $pos = static::cssPosition($row['position'] ?? 'center');
        return "style=\"--ph-bg:url('" . e($url) . "'); background-position:" . $pos . "\"";
    }
}
