<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Tank;
use App\TankStrapping;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TankStrappingsController extends Controller
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
		
		// Since Tank Strappings are assigned to Tanks, and not the Account themselves,
		// we have to grab all the Tank Strappings and their owners (Tanks->Leases->Operators->Customers) first,
		// then run a loop to get the Tanks. OR as in below, we run 3 left joins
		// to get all the Leases, Operators, and Customers to finally grab the correct leases in one query.
		DB::enableQueryLog();
		$strappings = TankStrapping::leftJoin('tanks', 'tank_strappings.tank_id', '=', 'tanks.id')
			->leftJoin('leases', 'tanks.lease_id', '=', 'leases.id')
			->leftJoin('operators', 'leases.operator_id', '=', 'operators.id')
			->leftJoin('customers', 'operators.customer_id', '=', 'customers.id')
			->where('customers.account_id', $currentUser->account->id)
			->select('tank_strappings.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/strappings/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'strappings' => $strappings,
		];

		return view('admin.strappings.index', $viewParams);
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

		return view('admin.strappings.create', $viewParams);
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
				'tank_id' => 'required',
				'qtr' => 'required',
				'rate' => 'required',
				'rateAbove' => 'required',
				'cumulative_bbls' => 'required',
			]);
		}

		$strapping = new TankStrapping();

		if($request->ajax()) {
			$strapping->tank_id = $request->params['tank_id'];
			$strapping->qtr = $request->params['qtr'];
			$strapping->rate = $request->params['rate'];
			$strapping->rateAbove = $request->params['rateAbove'];
			$strapping->cumulative_bbls = $request->params['cumulative_bbls'];
			$strapping->source = $request->params['source'];
		} else {
			$strapping->tank_id = $request->tank_id;
			$strapping->qtr = $request->qtr;
			$strapping->rate = $request->rate;
			$strapping->rateAbove = $request->rateAbove;
			$strapping->source = $request->source;
		}

		$strapping->created_by = Auth::user()->id;
		$strapping->updated_by = Auth::user()->id;

		$strapping->save();

		if($request->ajax()) return response()->json(['responseText' => 'Success!'], 200);
		else return redirect()->route('admin.strappings.index')->with('success', 'Successfully Created Tank Strapping!');
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

		$strapping = TankStrapping::find($id);

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js\"></script>
			<script src=\"//cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/strappings/show.js\"></script>
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
			'strapping' => $strapping,
		];

		return view('admin.strappings.show', $viewParams);
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

		$strapping = TankStrapping::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'strapping' => $strapping,
		];

		return view('admin.strappings.edit', $viewParams);
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

		$strapping = TankStrapping::find($id);

		$this->validate($request, [
			'tank_id' => 'required',
			'qtr' => 'required',
			'rate' => 'required',
			'rateAbove' => 'required',
			'cumulative_bbls' => 'required',
		]);

		$strapping->tank_id = $request->tank_id;
		$strapping->qtr = $request->qtr;
		$strapping->rate = $request->rate;
		$strapping->rateAbove = $request->rateAbove;
		$strapping->cumulative_bbls = $request->cumulative_bbls;
		$strapping->source = $request->source;

		$strapping->updated_by = Auth::user()->id;

		$strapping->save();

		return redirect()->route('admin.strappings.show', ['id'=>$id])->with('success', 'Successfully Edited Tank Strapping');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return text
	 */
	public function destroy($id)
	{
		$strapping = TankStrapping::findOrFail($id);

		$strapping->delete();

		return "success";
	}
}
