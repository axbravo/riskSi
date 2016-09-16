<?php

namespace App\Services;

use Config;

class FileService {

	public function upload($file, $type){
		$upload_path = Config::get('paths.upload_image');
		$extension = $file->getClientOriginalExtension();
		$file_path = $type.'_'.microtime().'.'.$extension;
        $file->move($upload_path, $file_path);
        return $upload_path.'/'.$file_path;
	}
}