<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Exception;

use Spatie\Backup\Tasks\Backup\BackupJobFactory;


 
class BackupController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index (Request $request) {

		$dir = storage_path('backups')."/etribunalv2";
		$files = glob($dir.'/*.*');

		usort($files, function($a,$b){
			return filemtime($b) - filemtime($a);
		});

        if($request->has('date') && !empty($request->date)) {
            $temp = [];

            foreach($files as $i => $file) {
                if(date('d/m/Y', filemtime($file)) == $request->date)
                    array_push($temp, $file);
            }

            $files = $temp;
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,3,"BackupController",null,null,"View backup ");
		//dd(basename($files1[0]));
		//dd(filesize($files1[0]));
		//dd(date('d/m/Y', filemtime($files1[0])));
		
		return view('admin.backup', compact('files'));
	}

    public function download (Request $request) {

        if($request->filename) {
            $path = storage_path('backups/etribunalv2/'.$request->filename);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,17,"BackupController",$request->filename,null,"Download Backup");
            return response()->download($path);
        }

    }

    public function delete (Request $request) {

        if($request->filename) {
            $path = storage_path('backups/etribunalv2/'.$request->filename);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"BackupController",null,null,"Delete backup ".$request->filename);

            unlink($path);

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'fail']);

    }


    

	public function store (Request $request) {

        $validator = Validator::make($request->all(), ['types' => 'required']);

        if(!$validator->passes()){
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        //if($request->types)

        $mode = $request->types ? count($request->types) > 1 ? 3 : $request->types[0] : 0;

        try {

            $backupJob = BackupJobFactory::createFromArray(config('laravel-backup'));

            if ($mode == 1) {
                $backupJob->doNotBackupFilesystem();
            }

            else if ($mode == 2) {
                $backupJob->doNotBackupDatabases();
            }

            if ($request->filename) {
                $backupJob->setFilename($request->filename.".zip");
            }

            $backupJob->run();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,4,"BackupController",json_encode($request->input()),null,"Backup ".$request->filename." - Create backup");
            return response()->json(['status' => 'ok']);
        } catch (Exception $exception) {
        	return response()->json(['status' => 'fail', 'message' => $exception->getMessage()]);
            //return response("Backup failed because: {$exception->getMessage()}.");
        }



  //       dd($request->input());
		
		// return view('admin.backup');
	}

	
}
