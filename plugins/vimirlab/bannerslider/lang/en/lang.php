<?php

return [
	'plugin' => [
		'name' => 'Banner Slider',
		'description' => 'Banner Slider Plugin',
		'author' => 'VimirLab',
	],
	
	'permission' => [
		'slider_tab' => 'Banner Slider',
		'sliders' => 'Manage Banner Slider',
	],
	
	'menu' => [
		'bannerslider' => 'Banner Slider',
		'slider' => 'Slider'
	],
	
	'form' => [
		'name' => 'Slider Name',
		'image' => 'Image',
		'display' => 'Display',
		'title' => 'Title',
		'title_size' => 'Font size',
		'title_color' => 'Title color',
		'subtitle' => 'Subtitle',
		'subtitle_size' => 'Font size',
		'subtitle_color' => 'Subtitle color',
		'extra_text' => 'Extra text',
		'extra_text_color' => 'Extra text color',
		'text_align' => 'Text align',
		'image_align' => 'Image align',
		'button_1_active' => 'Button 1',
		'button_2_active' => 'Button 2',
		'button_text' => 'Button text',
		'button_link' => 'Button link',
		'left' => 'Left',
		'center' => 'Center',
		'right' => 'Right',
		'id' => 'ID',
		'slides_count' => 'Number of slides',
	],
	
	'new' => [
		'slider' => 'Create slider',
		'slide' => 'Slider',
	],
	
	'flash' => [
		'slider_save' => 'The Slider has been sucessfuly created',
		'slider_update' => 'The Slider has been sucessfuly updated',
		'slider_delete' => 'The Slider has been sucessfuly deleted',
		'emptyMessage' => 'The slider dose not have slide.',
	],
	
	'title' => [
		'slider' => 'Sliders',
		'slider_create' => 'New slider',
		'slider_update' => 'Update slider',
		'relation' => 'New Slide',
		'creating_slide' => 'Creating slide ...',
		'return_slider' => 'Return to slider list',
		'reorder' => 'Reodrder',
	],
	
	'confirmation' => [
		'delete' => 'Do you really want to delete this slider?',
	],
	
	'components' => [
		'name' => 'Banner Slider',
		'description' => 'Display slider.',
		
		'properties' => [
			'slider_title' => 'Slider',
			'slider_description' => 'Select a slider which you display on the page.',
			'slider_placeholder' => 'Select slider',
		],
	],
];