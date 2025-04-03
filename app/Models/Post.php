<?php

namespace App\Models;

class Post
{
    public $id;
    public $title;
    public $content;

    public function __construct($id, $title, $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public static function all()
    {
        return [
            new self(1, "First", "Ths is the content"),
            new self(2, "Second", "Ths is the content"),
            new self(3, "Third", "Ths is the content"),
        ];
    }

    public static function find($id)
    {
        foreach (self::all() as $post) {
            if ($post->id == $id) {
                return $post;
            }
        }
        return null;
    }
}