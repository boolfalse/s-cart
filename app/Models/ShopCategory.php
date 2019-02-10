<?php
#app/Models/ShopCategory.php
namespace App\Models;

use App\Models\Config;
use App\Models\Language;
use App\Models\ShopCategoryDescription;
use App\Models\ShopProduct;
use Helper;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    public $timestamps = false;
    public $table      = 'shop_category';
    protected $appends = [
        'name',
        'keyword',
        'description',
    ];

    public function local()
    {
        $lang = Language::pluck('id', 'code')->all();
        return ShopCategoryDescription::where('shop_category_id', $this->id)
            ->where('lang_id', $lang[app()->getLocale()])
            ->first();
    }
    public function products()
    {
        return $this->hasMany(ShopProduct::class, 'category_id', 'id');
    }
    public function descriptions()
    {
        return $this->hasMany(ShopCategoryDescription::class, 'shop_category_id', 'id');
    }
    public function getTreeCategory($root = 0)
    {
        $list   = [];
        $result = $this->select('id', 'parent')
            ->where('parent', $root)
            ->get();
        foreach ($result as $value) {
            $list[$value['id']] = $value->getName();
            if ($this->getChildrens($value['id'])->count() > 0) {
                $this->getTreeCategoryTmp($value['id'], $list);
            }
        }
        return $list;
    }

    public function getTreeCategoryTmp($id, &$list, $st = '--')
    {
        $result = $this->select('id', 'parent')
            ->where('parent', $id)
            ->get();
        foreach ($result as $value) {
            $list[$value['id']] = $st . ' ' . $value->getName();
            $this->getTreeCategoryTmp($value['id'], $list, $st . '--');
        }

    }

    public function checkChild($id)
    {
        return $this->where('parent', $id)->count();
    }

    public function arrChild($id)
    {
        return $this->where('parent', $id)->pluck('id')->all();
    }

/**
 * Get category parent
 * @return [type]     [description]
 */
    public function getParent()
    {
        return $this->find($this->parent);

    }
/**
 * Get category child
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
    public function getCateChild($id)
    {
        return $this->with('products')->where('parent', $id)->get();
    }
/**
 * Get all products in category, include child category
 * @param  [type] $id    [description]
 * @param  [type] $limit [description]
 * @return [type]        [description]
 */
    public function getProductsToCategory($id, $limit = null, $opt = null)
    {
        $arrChild   = $this->arrChild($id);
        $arrChild[] = $id;
        $query      = (new ShopProduct)->where('status', 1)->whereIn('category_id', $arrChild)
            ->orWhereRaw('category_other like "' . $id . ',%" or category_other like "%,' . $id . '" or category_other like "%,' . $id . ',%"')
            ->sort();
        //Hidden product out of stock
        if ((int) Config::select('value')->where('key', 'product_display_out_of_stock')->first()->value == 0) {
            $query = $query->where('stock', '>', 0);
        }
        if (!(int) $limit) {
            return $query->get();
        } else
        if ($opt == 'paginate') {
            return $query->paginate((int) $limit);
        } else
        if ($opt == 'random') {
            return $query->inRandomOrder()->limit($limit)->get();
        } else {
            return $query->limit($limit)->get();
        }

    }
/**
 * [getCategories description]
 * @param  [type] $parent [description]
 * @return [type]         [description]
 */
    public static function getCategories($parent)
    {
        return self::where('status', 1)->where('parent', $parent)->sort()->get();
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($category) {
            $category->descriptions()->delete();
        });
    }

/**
 * Get category child
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
    public function getChildrens($id)
    {
        return $this->with('products')->where('parent', $id)->get();
    }

/**
 * [getThumb description]
 * @return [type] [description]
 */
    public function getThumb()
    {
        if ($this->image) {
            $path_file = config('filesystems.disks.path_file', '');
            if (!file_exists($path_file . '/thumb/' . $this->image)) {
                return $this->getImage();
            } else {
                if (!file_exists($path_file . '/thumb/' . $this->image)) {
                } else {
                    return $path_file . '/thumb/' . $this->image;
                }
            }
        } else {
            return 'images/no-image.jpg';
        }

    }

/**
 * [getImage description]
 * @return [type] [description]
 */
    public function getImage()
    {
        if ($this->image) {
            $path_file = config('filesystems.disks.path_file', '');
            if (!file_exists($path_file . '/' . $this->image)) {
                return 'images/no-image.jpg';
            } else {
                return $path_file . '/' . $this->image;
            }
        } else {
            return 'images/no-image.jpg';
        }

    }

    public function getUrl()
    {
        return route('category', ['name' => Helper::strToUrl($this->name), 'id' => $this->id]);
    }

//Fields language
    public function getName()
    {
        return empty($this->local()->name) ? '' : $this->local()->name;
    }
    public function getKeyword()
    {
        return empty($this->local()->keyword) ? '' : $this->local()->keyword;
    }
    public function getDescription()
    {
        return empty($this->local()->description) ? '' : $this->local()->description;
    }

//Attributes
    public function getNameAttribute()
    {
        return $this->getName();
    }
    public function getKeywordAttribute()
    {
        return $this->getKeyword();

    }
    public function getDescriptionAttribute()
    {
        return $this->getDescription();

    }

//Scort
    public function scopeSort($query, $column = null)
    {
        $column = $column ?? 'sort';
        return $query->orderBy($column, 'asc')->orderBy('id', 'desc');
    }

}
