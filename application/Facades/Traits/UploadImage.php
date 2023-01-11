<?php

namespace Application\Facades\Traits;

trait UploadImage{

	protected $uploaded_image;

	public function uploadImageWithThumb($image){
		$this->uploaded_image = $image;
		$CI =& get_instance();
		
		$config['image_library'] 	= 'gd2';
		$config['source_image'] 	= $image['full_path'];
		$config['create_thumb'] 	= TRUE;
		$config['maintain_ratio'] 	= TRUE;
		$config['width']         	= 75;
		$config['height']       	= 50;
		$config['new_image'] = '../../assets/img/avatar.png';

		$CI->load->library('image_lib', $config);
		$this->image_lib->resize() ?? false;
		die();
	}

}
