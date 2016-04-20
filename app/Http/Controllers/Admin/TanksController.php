<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Tank;
use App\Lease;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TanksController extends Controller
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
		
		// Since Tanks are assigned to Leases, and not the Account themselves,
		// we have to grab all the Leases and their owners (Operators -> Customers) first,
		// then run a loop to get the Tanks. OR as in below, we run 3 left joins
		// to get all the Leases, Operators, and Customers to finally grab the correct leases in one query.
		DB::enableQueryLog();
		$tanks = Tank::leftJoin('leases', 'tanks.lease_id', '=', 'leases.id')
			->leftJoin('operators', 'leases.operator_id', '=', 'operators.id')
			->leftJoin('customers', 'operators.customer_id', '=', 'customers.id')
			->where('customers.account_id', $currentUser->account->id)
			->select('tanks.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/tanks/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'tanks' => $tanks,
		];

		return view('admin.tanks.index', $viewParams);
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

		return view('admin.tanks.create', $viewParams);
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
				'number' => 'required',
			]);
		}

		$tank = new Tank();

		if($request->ajax()) {
			$tank->lease_id = $request->params['lease_id'];
			$tank->number = $request->params['number'];
			$tank->size = $request->params['size'];
			$tank->bbls_per_inch = $request->params['bbls_per_inch'];
		} else {
			$tank->lease_id = $request->lease_id;
			$tank->number = $request->number;
			$tank->size = $request->size;
			$tank->bbls_per_inch = $request->bbls_per_inch;
		}

		$tank->created_by = Auth::user()->id;
		$tank->updated_by = Auth::user()->id;

		$tank->save();

		if($request->ajax()) return response()->json(['responseText' => 'Success!'], 200);
		else return redirect()->route('admin.tanks.index')->with('success', 'Successfully Created Tank!');
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

		$tank = Tank::find($id);

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js\"></script>
			<script src=\"//cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/tanks/show.js\"></script>
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
			'tank' => $tank,
		];

		return view('admin.tanks.show', $viewParams);
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

		$tank = Tank::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'tank' => $tank,
		];

		return view('admin.tanks.edit', $viewParams);
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

		$tank = Tank::find($id);

		$this->validate($request, [
			'lease_id' => 'required',
			'number' => 'required',
		]);

		$tank->lease_id = $request->lease_id;
		$tank->number = $request->number;
		$tank->size = $request->size;
		$tank->bbls_per_inch = $request->bbls_per_inch;

		$tank->updated_by = Auth::user()->id;

		$tank->save();

		return redirect()->route('admin.tanks.show', ['id'=>$id])->with('success', 'Successfully Edited Tank');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return text
	 */
	public function destroy($id)
	{
		$tank = Tank::findOrFail($id);

		$tank->delete();

		return "success";
	}
}
