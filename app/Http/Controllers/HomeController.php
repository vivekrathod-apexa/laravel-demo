<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Document;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth'); remove auth for route fieupload
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
	/* documents upload */
	public function fieupload(Request $request){
		//get file data from request
		$uploadedFile = $request->file('file');
		$folderName = $uploadedFile->getClientOriginalName();
		$filename = time().$uploadedFile->getClientOriginalName();

		$fileupload = Storage::disk('public_uploads')->putFileAs(
					"",
					$uploadedFile,
					$filename
				  );
		// store document into database
		$upload = new Document;
		$upload->filename = $filename;
		$upload->file_path = asset('uploads').'/'.$filename;
		$upload->save();
		
		if($upload->save()){
			 return response()->json([
				'status'=>'ok',
				'code'=>'200',
				'message' => "File Upload Successfully !"
			  ]);
		}else{
			 return response()->json([
				'status'=>'error',
				'code'=>'400',
				'message' => "something went wrog pleae try again."
			  ]);
		}
     
	}
	
	
	/*get all documents*/
	public function getalldocuments(){
		$documents = Document::all();
		if($documents){
			 return response()->json([
				'status'=>'ok',
				'code'=>'200',
				'documents' => $documents,
				'message'=>'success'
			  ]);
		}else{
			 return response()->json([
				'status'=>'error',
				'code'=>'400',
				'message' => "something went wrog pleae try again."
			  ]);
		}
	}
}
?>