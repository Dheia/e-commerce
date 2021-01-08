<?php namespace Wapp\Basecode\Models;

use Illuminate\Contracts\Logging\Log;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Product;
use Model;
use October\Rain\Halcyon\Traits\Validation;
use RainLab\Blog\Models\Post;

/**
 * Settings Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'wapp_site_settings';
    public $settingsFields = 'fields.yaml';

    use Validation;

    /**
     * Get Settings value in Cache
     * @return null|string
    */

    public function getValue($value)
    {
        if (empty($this->settingsCode)) {
            return null;
        }

        //get settings object
        $obSettings = self::where('item', 'wapp_site_settings')->first();
        if (empty($obSettings)) {
            return null;
        }
        $sValue = $obSettings->$value;
        return $sValue;
    }

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'storeImage'   => 'nullable|image|max:4000',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'storeImage' => \System\Models\File::class,
        'logoHeader' => \System\Models\File::class,
        'logoFooter' => \System\Models\File::class,
    ];
    public $attachMany = ['attachments' => ['System\Models\File']];

    /**
     * get category list
     * @var array
     */
    public function getCategoryIdOptions()
    {
        $obCategoryList = Category::active()->orderBy('name', 'ASC')->lists('name', 'id');

        return $obCategoryList;
    }

    public function getProductIdOptions()
    {
        $obProductList = Product::active()->orderBy('name', 'ASC')->lists('name', 'id');

        return $obProductList;
    }

    public function getNewsIdOptions()
    {
        $obNewsList = Post::all()->where('published',true)->lists('title', 'id');

        return $obNewsList;
    }
}
