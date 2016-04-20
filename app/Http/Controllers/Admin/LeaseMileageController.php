<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\LeaseMileage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LeaseMileageController extends Controller
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
		
		$mileages = LeaseMileage::where('account_id', $currentUser->account->id)->get();

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/mileages/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'mileages' => $mileages,
		];

		return view('admin.mileages.index', $viewParams);
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

		return view('admin.mileages.create', $viewParams);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(!$request->ajax()) {
			$this->validate($request, [
				'lease_id' => 'required',
				'depot_id' => 'required',
				'mileage' => 'required',
			]);
		}

		$mileage = new LeaseMileage();

		if($request->ajax()) {
			$mileage->depot_id = $request->params['depot_id'];
			$mileage->lease_id = $request->params['lease_id'];
			$mileage->mileage = $request->params['mileage'];
		} else {
			$mileage->depot_id = $request->depot_id;
			$mileage->lease_id = $request->lease_id;
			$mileage->mileage = $request->mileage;
		}

		$mileage->created_by = Auth::user()->id;
		$mileage->updated_by = Auth::user()->id;

		$mileage->save();

		if($request->ajax()) return response()->json(['responseText' => 'Success!'], 200);
		else return redirect()->route('admin.mileages.index')->with('success', 'Successfully Created LeaseMileage!');
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

		$lease = LeaseMileage::find($id);

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js\"></script>
			<script src=\"//cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/mileages/show.js\"></script>
			<script src=\"/plugins/modal-effect/js/classie.js\"></script>
			<script src=\"/plugins/modal-effect/js/modalEffects.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'lease' => $lease,
		];

		return view('admin.mileages.show', $viewParams);
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

		$lease = LeaseMileage::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'lease' => $lease,
		];

		return view('admin.mileages.edit', $viewParams);
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

		$lease = LeaseMileage::find($id);

		$this->validate($request, [
			'operator_id' => 'required',
			'number' => 'required|unique:mileages',
			'name' => 'required',
			'state' => 'required',
			'county' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$lease->account_id = Auth::user()->account->id;
		$lease->operator_id = $request->operator_id;
		$lease->number = $request->number;
		$lease->name = $request->name;
		$lease->state = $request->state;
		$lease->county = $request->county;
		$lease->section = $request->section;
		$lease->latitude = $request->latitude;
		$lease->longitude = $request->longitude;

		$lease->updated_by = Auth::user()->id;

		$lease->save();

		return redirect()->route('admin.mileages.show', ['id'=>$id])->with('success', 'Successfully Edited LeaseMileage');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return text
	 */
	public function destroy($id)
	{
		$lease = LeaseMileage::findOrFail($id);

		$lease->delete();

		return "success";
	}
}
