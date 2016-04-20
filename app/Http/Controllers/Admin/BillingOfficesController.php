<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\BillingOffice;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BillingOfficesController extends Controller
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
		$offices = BillingOffice::leftJoin('customers', 'billing_offices.customer_id', '=', 'customers.id')->where('customers.account_id', $currentUser->account->id)->select('billing_offices.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/billing/index.js\"></script>
		";

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'offices' => $offices,
		];

		return view('admin.billing.index', $viewParams);
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

		return view('admin.billing.create', $viewParams);
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
			'name' => 'required',
			'customer' => 'required',
			'email' => 'required|email',
			'zip_code' => 'required',
		]);

		$office = new BillingOffice();

		$office->customer_id = $request->customer;
		$office->name = $request->name;
		$office->email = $request->email;
		$office->phone = $request->phone;
		$office->address = $request->address;
		$office->city = $request->city;
		$office->state = $request->state;
		$office->zip_code = $request->zip_code;

		$office->created_by = Auth::user()->id;
		$office->updated_by = Auth::user()->id;

		$office->save();

		return redirect()->route('admin.billing.index')->with('success', 'Successfully created Billing Office!');
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

		$office = BillingOffice::find($id);

		$styles="
			<link href=\"/plugins/datatables/jquery.dataTables.min.css\" rel=\"stylesheet\" type=\"text/css\">
		";

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/billing/show.js\"></script>
		";

		$viewParams = [
			'styles' => $styles,
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'office' => $office,
		];

		return view('admin.billing.show', $viewParams);
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

		$office = BillingOffice::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'office' => $office,
		];

		return view('admin.billing.edit', $viewParams);
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
			'name' => 'required',
			'email' => 'required|email',
			'zip_code' => 'required',
		]);

		$office = BillingOffice::find($id);

		$office->name = $request->name;
		$office->email = $request->email;
		$office->phone = $request->phone;
		$office->address = $request->address;
		$office->city = $request->city;
		$office->state = $request->state;
		$office->zip_code = $request->zip_code;

		$office->updated_by = Auth::user()->id;

		$office->save();

		return redirect()->route('admin.billing.show', ['id'=>$id])->with('success', 'Succefully updated Billing Office');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$office = BillingOffice::findOrFail($id);

		$office->delete();

		return "success";
	}
}
