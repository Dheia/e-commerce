<?php namespace VimirLab\BannerSlider\Components;

use Lang;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use October\Rain\Database\Model;
use October\Rain\Database\Collection;
use VimirLab\BannerSlider\Components\Sliders;
use VimirLab\BannerSlider\Models\Slider as NewSlider;
use VimirLab\BannerSlider\Models\Slide as Slide;

class Sliders extends ComponentBase
{
	public $slides;
	
    public function componentDetails()
    {
        return [
            'name'        => 'vimirlab.bannerslider::lang.components.name',
            'description' => 'vimirlab.bannerslider::lang.components.description'
        ];
    }
	
	public function defineProperties()
	{
		return [
			'slider' => [
				'title' => 'vimirlab.bannerslider::lang.components.properties.slider_title',
				'description' => 'vimirlab.bannerslider::lang.components.properties.slider_description',
				'placeholder' => Lang::get('vimirlab.bannerslider::lang.components.properties.slider_placeholder'),
				'type'          => 'dropdown'
			],
		];
	} 

    public function getSliderOptions()
    {
        return NewSlider::lists('title', 'id');
    }
	
	public function onRun()
    {
		$this->slides = $this->getSlides();
		
		$this->addCss('/plugins/vimirlab/bannerslider/assets/css/slider.min.css');
		$this->addCss('/plugins/vimirlab/bannerslider/assets/css/slider.css');
		$this->addJs('/plugins/vimirlab/bannerslider/assets/js/slider.min.js');
		$this->addJs('/plugins/vimirlab/bannerslider/assets/js/slider.js');
		
    } 	
	
	public function getSlides()
	{
		$sliderId = (int) $this->property('slider');
		
		$slides = Slide::where('slider_id', $sliderId)->where('display', 1)->get();
		
		return $slides;		
	}
}