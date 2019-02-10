<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class ShopBrand extends Model
{
    public $timestamps = false;
    public $table      = 'shop_brand';

    public function products()
    {
        return $this->hasMany(ShopProduct::class, 'brand_id', 'id');
    }
    public static function getBrands()
    {
        return self::where('status', 1)->orderBy('id', 'desc')->orderBy('sort', 'desc')->get();
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl()
    {
        return route('brand', ['name' => Helper::strToUrl($this->name), 'id' => $this->id]);
    }

    /**
     * [getImage description]
     * @return [type] [description]
     */
    public function getImage()
    {
        $path_file = config('filesystems.disks.path_file', '');
        return $path_file . '/' . $this->image;

    }
}
