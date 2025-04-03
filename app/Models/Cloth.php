<?php

// app/Models/Cloth.php
namespace App\Models;

class Cloth
{
    public $id;
    public $name;
    public $price;
    public $description;
    
    public function __construct($id, $name, $price, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
    
    // Static method to get all clothes
    public static function all()
    {
        return [
            new self(1, 'Jacket', 3000, 'Leather jacket with top closure'),
            new self(2, 'Shirt', 1500, 'Cotton shirt with button-down collar'),
            new self(3, 'Jeans', 2000, 'Denim jeans with slim fit'),
            new self(4, 'Sweater', 2500, 'Woolen sweater for winter'),
            new self(5, 'T-Shirt', 800, 'Casual cotton t-shirt')
        ];
    }
    
    // Find a cloth by id
    public static function find($id)
    {
        foreach (self::all() as $cloth) {
            if ($cloth->id == $id) {
                return $cloth;
            }
        }
        return null;
    }
}