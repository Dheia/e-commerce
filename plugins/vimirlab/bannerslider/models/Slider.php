<?php namespace VimirLab\BannerSlider\Models;

use Model;

class Slider extends Model
{	
	use \October\Rain\Database\Traits\Validation;
	
	public $table = 'vimirlab_bannerslider_sliders';
	
	protected $guarded = ['*'];	 
		
    public $rules = [
        'title' => 'required',
    ];

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    
    public $translatable = [
        'title'
    ];

    public $hasMany = [
        'slides' => [
            'VimirLab\BannerSlider\Models\Slide'
        ],
        'slides_count' => [
            'VimirLab\BannerSlider\Models\Slide',
            'count' => true
        ]
    ];
}