<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['name','slug','icon','image'];

    //Relacion de uno a muchos
    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    //Relacion  muchos a muchos
    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    //Relacion a traves de subcategory
    public function products(){
        return $this->hasManyThrough(Product::class,Subcategory::class);
    }

    //URL AMIGABLES
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
