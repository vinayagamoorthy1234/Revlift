<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Truck;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TrucksController extends Controller
{

	public function __construct()
	{
		$this->middleware('timeout');
	}

	/**
	 * Display accounts index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$currentUser = Auth::user();
		
		$trucks = Truck::where('account_id', $currentUser->account->id)->get();

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script>
				$(document).ready(function() {
					$('#datatable').DataTable({
						order: [
							[1, 'desc']
						],
						columns: [
							{ orderable: false },
							null,
							null,
							null,
							null,
							null,
						]
					});
				});
			</script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'trucks' => $trucks,
		];

		return view('admin.trucks.index', $viewParams);
	}

	/**
	 * Show the form for creating a new resource.
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

		return view('admin.trucks.create', $viewParams);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'truck_number' => 'required|unique:trucks',
			'owner' => 'required',
			'rate' => 'required',
		]);

		$truck = new Truck();

		$truck->account_id = Auth::user()->account->id;
		$truck->truck_number = $request->truck_number;
		$truck->owner = $request->owner;
		$truck->rate = $request->rate;

		$truck->created_by = Auth::user()->id;
		$truck->updated_by = Auth::user()->id;

		$truck->save();

		return redirect()->route('admin.trucks.index')->with('success', 'Successfully created truck!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$currentUser = Auth::user();

		$truck = Truck::find($id);

		$scripts = "
			<script src=\"/js/trucks/show.js\"></script>
		";

		$viewParams = [
			'styles' => '',
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'truck' => $truck,
		];

		return view('admin.trucks.show', $viewParams);
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

		$truck = Truck::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'truck' => $truck,
		];

		return view('admin.trucks.edit', $viewParams);
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

		$this->validate($request, [
			'truck_number' => 'required|unique:trucks',
			'owner' => 'required',
			'rate' => 'required',
		]);

		$truck = Truck::find($id);

		$truck->truck_number = $request->truck_number;
		$truck->owner = $request->owner;
		$truck->rate = $request->rate;

		$truck->updated_by = Auth::user()->id;

		$truck->save();

		return redirect()->route('admin.trucks.show', ['id'=>$id])->with('success', 'Successfully Edited Truck');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
			//
	}
}
