<?php

namespace App\Traits\TCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use File;
use App\Traits\Base;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait FileUploadHandler
{
    use Base;

		public $result;

		/**
		 * Check file validity and move to uploads folder
		 *
		 * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
		 * @return boolean
		 */

		public function projFileUpload($request, $resproject_id)
		{
			$oExt = $request->file('resprojfile')->getClientOriginalExtension();

			$destPath = "/public/".$this->projectIdFolder($resproject_id);
			$projFileName = $resproject_id."_".$this->generateCode(15).".".$oExt;
			$result['research_project_file'] = $projFileName;
			
			try {
					// Attempt file upload
					$path = $request->file('resprojfile')->storeAs($destPath, $projFileName);
					$result['project_file_path'] = $destPath;
					Log::channel('activity')->info("[ ".Auth::user()->name." ] uploaded project file name [ ".$projFileName." ]");
					$result['upload_status'] = true;
			} catch (\Exception $e) {
					// Show a user-friendly message
					Log::channel('activity')->info("[ ".Auth::user()->name." ] project file upload failed [ ".$projFileName." ]");
					$result['upload_status'] = false;
			}
			return $result;
		}

		public function resprojAppLettFileUpload($request, $resproject_id)
		{
			$oExt = $request->file('appletterfile')->getClientOriginalExtension();

			$destPath = "/public/".$this->projectIdFolder($resproject_id);
			$filename = $resproject_id."_approval_".$this->generateCode(15).".".$oExt;

			$result['sanction_letter_file'] = $filename;

			$path = $request->file('appletterfile')->storeAs($destPath, $filename);
			$result['sanction_file_path'] = $destPath;
			$result['upload_status'] = true;
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Res project approval letter [ '.$filename.']');
			return $result;
		}

		public function resprojReportFileUpload($request, $resproject_id)
		{
			$oExt = ".".$request->file('reportfile')->getClientOriginalExtension();
			
			$destPath = "/public/".$this->projectReportFileFolder($resproject_id);
			$filename = $resproject_id."_report_".$this->generateCode(12).$oExt;
			
			$result['report_filename'] = $filename;

			$path = $request->file('reportfile')->storeAs($destPath, $filename);
			$result['report_file_path'] = $destPath;

			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Res project report [ '.$filename.']');
			return $result;
		}
		
		public function serviceReportFileUpload($request, $infraName, $infra_id)
		{
			$oExt = ".".$request->file('userfile')->getClientOriginalExtension();

			$destPath = "/public/".$this->serviceReportFileFolder();

			$servRepFileName = $infra_id."_report_".$this->generateCode(15).$oExt;
			$result['service_report_filename'] = $servRepFileName;

			$path = $request->file('userfile')->storeAs($destPath, $servRepFileName);
			$result['service_report_path'] = $destPath;

			$result['upload_result'] = true;

			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Service report [ '.$servRepFileName.']');
			return $result;

		}
        
		public function uploadExptImageFiles($request, $resproject_id, $theme_id, $experiment_id)
		{
			$oExt = $request->file('userfile')->getClientOriginalExtension();

			$destPath = "/pulic/".$this->experimentImagesFolder($resproject_id, $theme_id, $experiment_id);

			$fileName = $resproject_id."_image_".$this->generateCode(8).".".$oExt;
			$result['expt_image_file'] = $fileName;

			$path = $request->file('userfile')->storeAs($destPath, $fileName);
			$result['expt_image_file_path'] = $destPath;

			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] uploaded Expt Image File [ '.$fileName.']');
			return $result;
		}
		
		/**
		 * Check file validity and move to uploads folder
		 *
		 * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
		 * @return boolean
		 */

		public function iaecProjFileUpload($request, $iaecproject_id)
		{
			$oExt = $request->file('userfile')->getClientOriginalExtension();

			$destPath = "/public/".$this->projectIdFolder($iaecproject_id);
			$projFileName = $iaecproject_id."_".$this->generateCode(15).".".$oExt;

			$this->result['iaecproject_filename'] = $projFileName;
			
			$path = $request->file('userfile')->storeAs($destPath, $projFileName);
			$this->result['iaecproject_file_path'] = $destPath;

			Log::channel('activity')->info("[ ".Auth::user()->name." ] uploaded project file name [ ".$projFileName." ]");
			return $this->result;
		}		

		public function soProcedureFileUpload($fileObj)
		{
			$oExt = $fileObj->getClientOriginalExtension();

			$destPath = "/public/".$this->sopFolderProcedures();
			$fileName = "SOP_".$this->generateCode(8).".".$oExt;

			$this->result['fileName'] = $fileName;

			$path = $fileObj->storeAs($destPath, $fileName);
			$this->result['file_path'] = $destPath;

			Log::channel('activity')->info("[ ".Auth::user()->name." ] uploaded project file name [ ".$fileName." ]");
			return $this->result;
		}

		public function soProtocolFileUpload($fileObj)
		{
			$oExt = $fileObj->getClientOriginalExtension();

			$destPath = "/public/".$this->sopFolderProtocols();
			$fileName = "SOP_".$this->generateCode(8).".".$oExt;

			$this->result['fileName'] = $fileName;

			$path = $fileObj->storeAs($destPath, $fileName);
			$this->result['file_path'] = $destPath;

			Log::channel('activity')->info("[ ".Auth::user()->name." ] uploaded project file name [ ".$fileName." ]");
			return $this->result;
		}
        
}
