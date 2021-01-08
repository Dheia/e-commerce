<?php namespace VimirLab\BannerSlider\Models;

use Model;
use Carbon\Carbon;
use October\Rain\Database\Traits\Sortable;

class Slide extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
	
	public $table='vimirlab_bannerslider_slides';
	
	protected $guarded = ['*'];
	
	public $rules = [
		'image' 		=> ['required']
	];
    
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = [
        'title',
        'subtitle',
        'extra_text',
        'button_1_text',
        'button_2_text',
        'button_1_link',
        'button_2_link'
    ];

    public $attachOne = [
        'image' => [
            'System\Models\File'
        ]
    ];
	
    public $belongsTo = [
        'slideshow' => [
            'VimirLab\BannerSlider\Models\Slider'
        ]
    ];
}
