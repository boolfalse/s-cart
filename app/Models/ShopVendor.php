<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class ShopVendor extends Model
{
    public $timestamps = false;
    public $table      = 'shop_vendor';

    public function products()
    {
        return $this->hasMany(ShopProduct::class, 'vendor_id', 'id');
    }
    public static function getVendor()
    {
        return self::where('status', 1)->sort()->get();
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl()
    {
        return url('vendor/' . Helper::strToUrl($this->name) . '_' . $this->id . '.html');
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

    //Scort
    public function scopeSort($query, $column = null)
    {
        $column = $column ?? 'sort';
        return $query->orderBy($column, 'asc')->orderBy('id', 'desc');
    }
}
