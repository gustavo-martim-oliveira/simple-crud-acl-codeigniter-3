<?php

namespace Application\Facades;

use Exception;

class Image {

	/**
	 * Set the uploaded image file 
	 *
	 * @var array
	 */
	private $image;

	/**
	 * Extensions allowed
	 *
	 * @var array
	 */
	private $allowed_extensions = ['jpg', 'gif', 'bmp', 'jpeg', 'png'];

	/**
	 * Max filesize in bytes
	 *
	 * @var string
	 */
	private $max_filesize = '2097152';

	/**
	 * Allowed Mime Types
	 *
	 * @var array
	 */
	private $mime_type = [
		'jpeg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'jpg' => 'image/jpeg',
		'png' => 'image/png',
	];

	/**
	 * Get the original filename
	 *
	 * @var string
	 */
	protected $real_filename;

	/**
	 * Get the original extension
	 *
	 * @var string
	 */
	protected $real_extension;

	/**
	 * Get the original filesize
	 *
	 * @var string
	 */
	protected $real_size;

	/**
	 * Get the original mimetype
	 *
	 * @var string
	 */
	protected $real_mime;

	/**
	 * Get the errors
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Return if has errors
	 *
	 * @var bool
	 */
	protected $hasErrors = false;

	protected $full_path;

	protected $thumbnail_width = 75;
	protected $thumbnail_height = 75;

	protected $thumbnail_path;

	public function __construct(array $file) {
		$this->image = $file;
		$this->fileReader($this->image);
	}

	public function getImage(){
		return $this->image;
	}

	public function getOriginalFileName(){
		if($this->hasErrors){
			return $this->errors;
		}
		return $this->real_filename;
	}

	public function getOriginalExtension(){

		if($this->hasErrors){
			return $this->errors;
		}
		return $this->real_extension;
	}

	public function getOriginalMime(){

		if($this->hasErrors){
			return $this->errors;
		}
		return $this->real_mime;
	}

	public function getOriginalSize(){

		if($this->hasErrors){
			return $this->errors;
		}
		return $this->real_size;
	}

	public function getFullPath(){
		return $this->full_path;
	}

	public function getThumbnailFullPath(){
		return $this->thumbnail_path;
	}

	public function setThumbDimension(int $width, int $height) : Image{
		$this->thumbnail_width = (int) $width;
		$this->thumbnail_height = (int) $height;
		return $this;
	}

	public function errors(){
		return $this->hasErrors;
	}

	public function messages(){
		return $this->errors;
	}

	public function upload($path, $thumbnail = false, $thumbnail_path = null) : Image {

		$this->checkDir($path);
		$path = str_replace('\\', '/', $path);
		$file = $path . '/' . md5($this->real_filename . date('dmyhis')) . '.' . $this->real_extension;

		$image = $this->image;
		if(!move_uploaded_file(
				$image['tmp_name'], 
				 $file
			)){

			$this->hasErrors = true;
			$this->errors[] = 'Falha ao enviar arquivo:' . $path . md5($this->real_filename . date('dmyhis')) . '.' . $this->real_extension;

		}

		$this->full_path = $file;

		if($thumbnail){

			if($thumbnail_path == null){
				$thumbnail_path = $path . '/thumb/';
				$this->checkDir($thumbnail_path);
			}
			if(!$this->thumbnail($file, $this->real_filename, $this->real_extension, $thumbnail_path)){
				$this->hasErrors = true;
				$this->errors[] = "Não foi possível gerar miniatura da imagem: {$this->real_filename}";
			}

		}
		
		return $this;
	}

	protected function fileReader($file){

		if(!in_array(pathinfo($file['full_path'], PATHINFO_EXTENSION), $this->allowed_extensions)){
			$this->hasErrors = true;
			$this->errors[] = "Extensão de arquivo inválida!";
		}else{
			$this->real_extension = pathinfo($file['full_path'], PATHINFO_EXTENSION);
		}

		if($file['type'] != $this->mime_type[$this->real_extension]){
			$this->hasErrors = true;
			$this->errors[] = "Esta não parece ser um tipo imagem válida!";
		}else{
			$this->real_mime = mime_content_type($file['tmp_name']);
		}			

		if($file['size'] > $this->max_filesize){
			$this->hasErrors = true;
			$this->errors[] = "O tamanho do arquivo não pode ser maior do que o especificado!";
		}else{
			$this->real_size = $file['size'];
		}

		$this->real_filename = $file['name'];

	}

	protected function checkDir($path){
		if(!is_dir($path)){
			mkdir($path, 0777, true);
		}
	}

	protected function thumbnail($original, $original_name, $extension, $path){

		$thumbnail = false;
		$file = $path.'/thumb_'.$original_name;

		switch($extension){
			case "png":
				$thumbnail = imagecreatefrompng($original);
				break;
			case "bmp":
				$thumbnail = imagecreatefrombmp($original);
			case "jpg":
			case "jpeg":
				$thumbnail = imagecreatefromjpeg($original);
				break;
			case "gif":
				$thumbnail = imagecreatefromgif($original);
				break;

			default:
				$thumbnail = false;
				break;
		}

		if(!$thumbnail){
			return false;
		}

		$x = imagesx($thumbnail);
		$y = imagesy($thumbnail);
	

		if($x > $y) { 
			$final_x = $this->thumbnail_width;
			$final_y = floor($this->thumbnail_width * $this->thumbnail_height / $this->thumbnail_width); 
			$f_x = 0;
			$f_y = round(($this->thumbnail_height / 2) - ($final_y / 2)); 
		} else {
			$final_x = floor($this->thumbnail_height * $this->thumbnail_width / $this->thumbnail_height); 
			$final_y = $this->thumbnail_height; 
			$f_x = round(($this->thumbnail_width / 2) - ($final_x / 2)); 
			$f_y = 0;
		}
		
		try{
			$final = ImageCreate($this->thumbnail_width,$this->thumbnail_height);
			ImageCopyResized($final, $thumbnail, $f_x, $f_y, 0, 0, $final_x, $final_y, $x, $y);
			
			$this->thumbnail_path = ImageJPEG($final, $file);
			
			ImageDestroy($thumbnail);
			ImageDestroy($final);
	
			return true;
		}catch(Exception $e){
			return false;
		}


	}
}
