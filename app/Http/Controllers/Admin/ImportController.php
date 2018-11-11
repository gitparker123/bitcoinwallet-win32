<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Import;
use App\City;
use App\Http\Requests\CreateImportRequest;
use App\Http\Requests\UpdateImportRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;


class ImportController extends Controller {

	/**
	 * Display a listing of import
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $import = Import::all();

		return view('admin.import.index', compact('import'));
	}

	/**
	 * Show the form for creating a new import
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.import.create');
	}

	/**
	 * Store a newly created import in storage.
	 *
     * @param CreateImportRequest|Request $request
	 */
	public function store(CreateImportRequest $request)
	{
	    $request = $this->saveFiles($request);
		Import::create($request->all());
		$csv_name = $request->input('file_name');
		$this->loadData($csv_name);

		return redirect()->route(config('quickadmin.route').'.import.index');
	}

	/**
	 * Show the form for editing the specified import.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$import = Import::find($id);
	    
	    
		return view('admin.import.edit', compact('import'));
	}

	/**
	 * Update the specified import in storage.
     * @param UpdateImportRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateImportRequest $request)
	{
		$import = Import::findOrFail($id);

        $request = $this->saveFiles($request);

		$import->update($request->all());

		return redirect()->route(config('quickadmin.route').'.import.index');
	}

	/**
	 * Remove the specified import from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Import::destroy($id);

		return redirect()->route(config('quickadmin.route').'.import.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Import::destroy($toDelete);
        } else {
            Import::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.import.index');
	}
	
	private function loadData($table)
	{
		ini_set('max_execution_time', 60 * 60 * 24 * 10);
		if (($handle = fopen ( url('/uploads/'.$table), 'r' )) !== FALSE) {
			while ( ($data = fgetcsv ( $handle, 1000, ',' )) !== FALSE ) {
				$csv_data = new City ();
				$csv_data->country = $data[0];
				$csv_data->city = $data[1];
				$csv_data->region = ($data[3])? $data[3] : 0;
				$csv_data->latitude = ($data[5])? $data[5] : 0;
				$csv_data->longitude = ($data[6])? $data[6] : 0;
				if(!$data[0]&&!$data[1]&&!$data[2]&&!$data[3]&&!$data[4]&&!$data[5])
					break;
				$csv_data->save();
			}
			fclose ( $handle );
		}
	}

}
