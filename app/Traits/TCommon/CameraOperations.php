<?php

namespace App\Traits\TCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Elab\Products;
use App\Models\Elab\Exptimage;
use App\Models\Elab\Exptfile;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

use Intervention\Image\Format;
use Intervention\Image\Laravel\Facades\Image;
//use Intervention\Image\ImageManager;

trait CameraOperations
{
	//use Image;
	
	public $camera;



  //....... Camera Image Processing .......//
	public function processImage($image)
	{
		//dd("reaching child trait component");
		if($this->imagenotes == null) 
		{
				$this->imagenotes = "profile";
		}
        
		//get the image from input field and remove the tags
		$imageBlob = str_replace('data:image/jpeg;base64,', '', $image);
		$file_type = "jpeg";
		// erase the space
		$imageBlob = str_replace(' ', '+', $imageBlob);
		
		// decode from base64
		$imageF = base64_decode($imageBlob);
		
		//storage paths and file name
		$base = "app/public/";
		$folder = "expts/cameraimages/".$this->expt_id."/";
		$code10 = $this->generateCode(10);
		$fileName = $code10."_Expt".$this->expt_id.".jpeg";
		
		$dirPath = storage_path($base.$folder); 
		if (!file_exists($dirPath)) {
			mkdir($dirPath, 0777, true);
		}
		
		//saving raw file captured without writing
		Storage::disk('public')->put($folder.$fileName, $imageF);
			
		// log the activity
		Log::channel('activity')->info('[ '.tenant('id').' ] [ '.Auth::user()->name.' ]'.' saved image [ '.$fileName.' ]');  
		
		//intervention processing for labeling
		$imgFile = Image::read($imageF);
		
		$imprinText = $this->expt_id." D: ".date('d-m-Y');
		
		$imgFile->text('----- Expt ID '.$imprinText, 120, 40, function($font) { 
		$font->file(public_path('roboto/static/Roboto-Bold.ttf'));
		$font->size(20);  
		$font->color('#ffffff');  
		$font->align('center');  
		$font->valign('bottom');  
		//$font->angle(180);  
		})->save(storage_path($base.$folder.$fileName)); 
			
		// log the activity
		Log::channel('activity')->info('[ '.Auth::user()->name.' ] saved Image with name [ '.$imprinText.' ]'); 

		//now store the filename in db Mugshot
		$nImage = new Exptimage();
		
		$nImage->experiment_id = $this->expt_id;
		$nImage->user_id = Auth::user()->id;
		$nImage->user_name = Auth::user()->name;
		$nImage->entry_date = date('Y-m-d');
		$nImage->image_file = $fileName;;
		$nImage->video_file = $fileName;
		$nImage->notes = $this->imagenotes;
		$nImage->path = $base.$folder;
		$nImage->save();

		$nExptFile = new Exptfile();
		
		$nExptFile->experiment_id = $this->expt_id;
		$nExptFile->user_id = Auth::user()->id;
		$nExptFile->user_name = Auth::user()->name;
		$nExptFile->entry_date = date('Y-m-d');
		$nExptFile->file_type = $file_type;
		$nExptFile->file_name = $fileName;
		$nExptFile->description = "";
		$nExptFile->legend = $this->imagenotes;
		$nExptFile->notes = $this->imagenotes;
		$nExptFile->path = $base.$folder;
		$nExptFile->save();
		
		// log the activity
		Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] saved Image for expt id [ '.$this->expt_id.' ]'); 
		
		// dd('Image uploaded successfully: '.$fileName);
		$message = "Image Saved Successfully";
		$this->alertSuccess($message);
		$this->dispatch('camera-on', ['newImage' => $this->value]);
       
  }
	//....... End of Camera Image Processing .......//



}