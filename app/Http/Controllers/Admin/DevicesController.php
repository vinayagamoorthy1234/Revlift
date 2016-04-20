<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Device;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DevicesController extends Controller
{

	public function __construct()
	{
		$this->middleware('timeout');
	}

	/**
	 * Display devices index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$currentUser = Auth::user();
		
		$devices = Device::where('account_id', $currentUser->account->id)->get();

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/devices/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'devices' => $devices,
		];

		return view('admin.devices.index', $viewParams);
	}
	
	/**
	 * Show the form for creating a new device.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$currentUser = Auth::user();

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
		];

		return view('admin.devices.create', $viewParams);
	}
	
	/**
	 * Store a newly created device in the database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'truck_id' => 'required',
			'type' => 'required',
			'serial' => 'required|unique:devices,serial',
			'tag_number' => 'required',
		]);

		$device = new Device();

		$device->account_id = Auth::user()->account->id;
		$device->truck_id = $request->truck_id;
		$device->type = $request->type;
		$device->serial = $request->serial;
		$device->tag_number = $request->tag_number;

		$device->created_by = Auth::user()->id;
		$device->updated_by = Auth::user()->id;

		$device->save();

		return redirect()->route('admin.devices.index')->with('success', 'Successfully created the device!');
	}
	
	/**
	 * Display the user details.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$currentUser = Auth::user();

		$device = Device::find($id);

		$scripts = "
			<script src=\"/js/devices/show.js\"></script>
		";

		$viewParams = [
			'styles' => '',
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'device' => $device,
		];

		return view('admin.devices.show', $viewParams);
	}	
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$currentUser = Auth::user();

		$device = Device::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'device' => $device,
		];

		return view('admin.devices.edit', $viewParams);
	}

	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$device = Device::find($id);
		$currentUser = Auth::user();

		if($request->serial == $device->serial) {
			$serial = 'required';
		} else {
			$serial = 'required|unique:devices,serial';
		}

		$this->validate($request, [
			'truck_id' => 'required',
			'type' => 'required',
			'serial' => $serial,
			'tag_number' => 'required',
		]);

		$device->truck_id = $request->truck_id;
		$device->type = $request->type;
		$device->serial = $request->serial;
		$device->tag_number = $request->tag_number;

		$device->updated_by = $currentUser->id;

		$device->save();

		return redirect()->route('admin.devices.show', ['id'=>$id])->with('success', 'Successfully updated device!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
			$device = Device::findOrFail($id);

			$device->delete();

			return "success";
	}
}
