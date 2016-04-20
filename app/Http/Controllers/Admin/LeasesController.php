<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Lease;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LeasesController extends Controller
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
		
		// Since Leases are assigned to Operators, and not the Account themselves,
		// we have to grab all the Operators and their owners (Customers) first,
		// then run a loop to get the Operators. OR as in below, we run two left joins
		// to get all the Operators and Customers to finally grab the correct leases in one query.
		DB::enableQueryLog();
		$leases = Lease::leftJoin('operators', 'leases.operator_id', '=', 'operators.id')
			->leftJoin('customers', 'operators.customer_id', '=', 'customers.id')
			->where('customers.account_id', $currentUser->account->id)
			->select('leases.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/leases/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'leases' => $leases,
		];

		return view('admin.leases.index', $viewParams);
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

		return view('admin.leases.create', $viewParams);
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
			'operator_id' => 'required',
			'billing_office_id' => 'required',
			'number' => 'required|unique:leases',
			'name' => 'required',
			'state' => 'required',
			'county' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$lease = new Lease();

		$lease->operator_id = $request->operator_id;
		$lease->billing_office_id = $request->billing_office_id;
		$lease->number = $request->number;
		$lease->name = $request->name;
		$lease->state = $request->state;
		$lease->county = $request->county;
		$lease->section = $request->section;
		$lease->latitude = $request->latitude;
		$lease->longitude = $request->longitude;

		$lease->created_by = Auth::user()->id;
		$lease->updated_by = Auth::user()->id;

		$lease->save();

		return redirect()->route('admin.leases.index')->with('success', 'Successfully Created Lease!');
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

		$lease = Lease::find($id);

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js\"></script>
			<script src=\"//cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/leases/show.js\"></script>
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

		return view('admin.leases.show', $viewParams);
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

		$lease = Lease::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'lease' => $lease,
		];

		return view('admin.leases.edit', $viewParams);
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

		$lease = Lease::find($id);

		if($request->number != $lease->number) $isDifferent = '|unique:leases';
		else $isDifferent = '';

		$this->validate($request, [
			'operator_id' => 'required',
			'billing_office_id' => 'required',
			'number' => 'required'.$isDifferent,
			'name' => 'required',
			'state' => 'required',
			'county' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$lease->operator_id = $request->operator_id;
		$lease->billing_office_id = $request->billing_office_id;
		$lease->number = $request->number;
		$lease->name = $request->name;
		$lease->state = $request->state;
		$lease->county = $request->county;
		$lease->section = $request->section;
		$lease->latitude = $request->latitude;
		$lease->longitude = $request->longitude;

		$lease->updated_by = Auth::user()->id;

		$lease->save();

		return redirect()->route('admin.leases.show', ['id'=>$id])->with('success', 'Successfully Edited Lease');
	}

	/**
	 * Soft delete the Lease
	 *
	 * @param  int  $id
	 * @return text/json
	 */
	public function destroy($id)
	{
		$lease = Lease::findOrFail($id);

		$lease->delete();

		return "success";
	}
}
