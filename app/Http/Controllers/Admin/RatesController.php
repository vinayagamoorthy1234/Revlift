<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Rate;
use App\BaseRate;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RatesController extends Controller
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
		
		// Since Billing Offices are assigned to Customers, and not the Account themselves,
		// we have to grab all the Customers first, then run a loop to get the Allocations.
		// OR as in below, we run a left join to get all the Customers and their Billing Offices in one query.
		DB::enableQueryLog();
		$rates = Rate::leftJoin('billing_offices', 'rates.billing_office_id', '=', 'billing_offices.id')
			->leftJoin('customers', 'billing_offices.customer_id', '=', 'customers.id')
			->where('customers.account_id', $currentUser->account->id)->select('rates.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/rates/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'rates' => $rates,
		];

		return view('admin.rates.index', $viewParams);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$currentUser = Auth::user();

		$scripts = '
			<script src="/js/rates/create.js"></script>
		';

		$viewParams = [
			'styles' => '',
			'scripts' => $scripts,
			'currentUser' => $currentUser,
		];

		return view('admin.rates.create', $viewParams);
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
				'name' => 'required|unique:rates',
				'billing_office' => 'required',
				'chain_up_fee' => 'required',
				'chain_up_pay' => 'required',
				'demm_fee' => 'required',
			]);
		}

		$rate = new Rate();

		$baseRateArray = [];

		if($request->ajax()) {
			$rate->billing_office_id = $request->params['billing_office_id'];
			$rate->name = $request->params['name'];
			$rate->chain_up_pay = $request->params['chain_up_pay'];
			$rate->chain_up_fee = $request->params['chain_up_fee'];
			$rate->demm_fee = $request->params['demm_fee'];
			$rate->divert_fee = $request->params['divert_fee'];
			$rate->reject_fee = $request->params['reject_fee'];
			$rate->split_fee = $request->params['split_fee'];
			$rate->masking_fee = $request->params['masking_fee'];
			$rate->fsc_formula = $request->params['fsc_formula'];
			$rate->min_bbls = $request->params['min_bbls'];
			$rate->nc_demm_hrs = $request->params['nc_demm_hrs'];
			$rate->discount = $request->params['discount'];
			$rate->is_default = $request->params['is_default'];



			foreach ($request->params['base_rate_mileage'] as $key => $mileage) {
				$baseRateArray[$mileage] = $request->params['base_rate_value'][$key];
			}

		} else {
			$rate->billing_office_id = $request->billing_office;
			$rate->name = $request->name;
			$rate->chain_up_pay = $request->chain_up_pay;
			$rate->chain_up_fee = $request->chain_up_fee;
			$rate->demm_fee = $request->demm_fee;
			$rate->divert_fee = $request->divert_fee;
			$rate->reject_fee = $request->reject_fee;
			$rate->split_fee = $request->split_fee;
			$rate->masking_fee = $request->masking_fee;
			$rate->fsc_formula = $request->fsc_formula;
			$rate->min_bbls = $request->min_bbls;
			$rate->nc_demm_hrs = $request->nc_demm_hrs;
			$rate->discount = $request->discount;
            $rate->is_default = $request->is_default;
			foreach ($request->base_rate_mileage as $key => $mileage) {
				$baseRateArray[$mileage] = $request->base_rate_value[$key];
			}
		}

		$rate->created_by = Auth::user()->id;
		$rate->updated_by = Auth::user()->id;

		$rate->save();

		foreach($baseRateArray as $mileage => $br) {
			$baseRate = new BaseRate();
			if($request->ajax()) $baseRate->billing_office_id = $request->params['billing_office_id'];
			else $baseRate->billing_office_id = $request->billing_office;
			$baseRate->created_by = Auth::user()->id;
			$baseRate->updated_by = Auth::user()->id;
			$baseRate->mileage = $mileage;
			$baseRate->base_rate = $br;
			$baseRate->save();
		}

		if($request->ajax()) return response()->json(['responseText' => 'Success!'], 200);
		else return redirect()->route('admin.rates.index')->with('success', 'Successfully created Rate!');
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

		$rate = Rate::find($id);

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/rates/show.js\"></script>
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'rate' => $rate,
		];

		return view('admin.rates.show', $viewParams);
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

		$rate = Rate::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'rate' => $rate,
		];

		return view('admin.rates.edit', $viewParams);
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
			'name' => 'required|unique:rates',
			'billing_office' => 'required',
			'chain_up_fee' => 'required',
			'chain_up_pay' => 'required',
			'demm_fee' => 'required',
		]);

		$rate = Rate::find($id);

		$rate->billing_office_id = $request->billing_office;
		$rate->name = $request->name;
		$rate->chain_up_pay = $request->chain_up_pay;
		$rate->chain_up_fee = $request->chain_up_fee;
		$rate->demm_fee = $request->demm_fee;
		$rate->divert_fee = $request->divert_fee;
		$rate->reject_fee = $request->reject_fee;
		$rate->split_fee = $request->split_fee;
		$rate->masking_fee = $request->masking_fee;
		$rate->fsc_formula = $request->fsc_formula;
		$rate->load_barrels = $request->load_barrels;
		$rate->load_time = $request->load_time;
		$rate->min_bbls = $request->min_bbls;
		$rate->nc_demm_hrs = $request->nc_demm_hrs;
		$rate->discount = $request->discount;
		$rate->is_default = $request->is_default;

		$rate->updated_by = Auth::user()->id;

		$rate->save();

		return redirect()->route('admin.rates.show', ['id'=>$id])->with('success', 'Successfully updated Rate');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$rate = Rate::findOrFail($id);

		$rate->delete();

		return "success";
	}
}
