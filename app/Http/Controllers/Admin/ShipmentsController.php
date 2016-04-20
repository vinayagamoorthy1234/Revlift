<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Rate;
use App\Depot;
use App\Lease;
use App\Shipment;
use App\LeaseMileage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShipmentsController extends Controller
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
		
		$shipments = Shipment::where('account_id', $currentUser->account->id)->get();

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
			'shipments' => $shipments,
		];

		return view('admin.shipments.index', $viewParams);
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
			'styles' => '
				<link href="/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
				<link href="/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
			',
			'scripts' => '
				<script src="/plugins/timepicker/bootstrap-timepicker.min.js"></script>
				<script src="/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
				<script type="text/javascript" src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
			',
			'currentUser' => $currentUser,
		];

		return view('admin.shipments.create', $viewParams);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(empty($request->split_load)) $request->split_load = 0;
		if(empty($request->rejected_load)) $request->rejected_load = 0;
		if(empty($request->demm_hrs)) $request->demm_hrs = 0;
		if(empty($request->demm_reason)) $request->demm_reason = '';
		if(empty($request->divert_hrs)) $request->divert_hrs = 0;
		if(empty($request->divert_reason)) $request->divert_reason = '';
		if(empty($request->chain_up)) $request->chain_up = 0;
		if(empty($request->masking_up)) $request->masking_up = 0;

		$this->validate($request, [
			'ticket_number' => 'required|unique:shipments',
			'ticket_date' => 'required',
			'lease_id' => 'required',
			'operator_id' => 'required',
			'driver_id' => 'required',
			'truck_id' => 'required',
			'trailer_id' => 'required',
			'depot_id' => 'required',
			'header_id' => 'required',
			'tank_id' => 'required',
		]);

		$shipment = new Shipment();

		$shipment->account_id = Auth::user()->account->id;
		$shipment->ticket_number = $request->ticket_number;
		$shipment->ticket_date = $request->ticket_date;
		$shipment->operator_id = $request->operator_id;
		$shipment->driver_id = $request->driver_id;
		$shipment->truck_id = $request->truck_id;
		$shipment->trailer_id = $request->trailer_id;
		$shipment->lease_id = $request->lease_id;
		$shipment->depot_id = $request->depot_id;
		$shipment->header_id = $request->header_id;
		$shipment->tank_id = $request->tank_id;
		$shipment->tmw_or_fob = $request->tmw_or_fob;
		$shipment->depot_time_on = $request->depot_time_on;
		$shipment->depot_time_off = $request->depot_time_off;
		$shipment->lease_time_on = $request->lease_time_on;
		$shipment->lease_time_off = $request->lease_time_off;
		$shipment->top_feet = $request->top_feet;
		$shipment->top_inches = $request->top_inches;
		$shipment->top_qtr_inches = $request->top_qtr_inches;
		$shipment->bot_feet = $request->bot_feet;
		$shipment->bot_inches = $request->bot_inches;
		$shipment->bot_qtr_inches = $request->bot_qtr_inches;
		$shipment->obs_temp = $request->obs_temp;
		$shipment->top_temp = $request->top_temp;
		$shipment->bot_temp = $request->bot_temp;
		$shipment->obs_gravity = $request->obs_gravity;
		$shipment->bsw = $request->bsw;
		$shipment->split_load = $request->split_load;
		$shipment->rejected_load = $request->reject_load;
		$shipment->demm_hrs = $request->demm_hrs;
		$shipment->demm_reason = $request->demm_reason;
		$shipment->chain_up = $request->chain_up;
		$shipment->masking_up = $request->masking_up;
		$shipment->notes = $request->notes;

		$shipment->created_by = Auth::user()->id;
		$shipment->updated_by = Auth::user()->id;

		$shipment->save();

		return redirect()->route('admin.shipments.index')->with('success', 'Successfully created shipment ticket!');
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

		$shipment = Shipment::find($id);

		$scripts = "
			<script>
			$(document).ready(function() {
				$('#sa-warning').click(function(){
					swal({
						title: \"Are you sure?\",
						text: \"You will not be able to recover this shipment!\",
						type: \"warning\",
						showCancelButton: true,
						confirmButtonColor: \"#DD6B55\",
						confirmButtonText: \"Yes, delete it!\",
						closeOnConfirm: false 
					}, function(){
						swal({
							title:\"Deleted!\",
							text: \"Company has been deleted.\",
							type: \"success\"
						}, function(){
							console.log('Clicked OK');
							// Run ajax here.
						});
					});
				});
			});
			</script>
		";

		$viewParams = [
			'styles' => '',
			'scripts' => $scripts,
			'currentUser' => $currentUser,
			'shipment' => $shipment,
		];

		return view('admin.shipments.show', $viewParams);
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

		$shipment = Shipment::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'shipment' => $shipment,
		];

		return view('admin.shipments.edit', $viewParams);
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
			'ticket_number' => 'required|unique:shipments',
			'ticket_date' => 'required',
			'lease_id' => 'required',
			'operator_id' => 'required',
			'driver_id' => 'required',
			'truck_id' => 'required',
			'trailer_id' => 'required',
			'depot_id' => 'required',
			'header_id' => 'required',
			'tank_id' => 'required',
		]);

		$shipment = new Shipment();

		$shipment->account_id = Auth::user()->account->id;
		$shipment->ticket_number = $request->ticket_number;
		$shipment->operator_id = $request->operator_id;
		$shipment->driver_id = $request->driver_id;
		$shipment->truck_id = $request->truck_id;
		$shipment->trailer_id = $request->trailer_id;
		$shipment->lease_id = $request->lease_id;
		$shipment->depot_id = $request->depot_id;
		$shipment->header_id = $request->header_id;
		$shipment->tank_id = $request->tank_id;
		$shipment->tmw_or_fob = $request->tmw_or_fob;
		$shipment->depot_time_on = $request->depot_time_on;
		$shipment->depot_time_off = $request->depot_time_off;
		$shipment->lease_time_on = $request->lease_time_on;
		$shipment->lease_time_off = $request->lease_time_off;
		$shipment->top_feet = $request->top_feet;
		$shipment->top_inches = $request->top_inches;
		$shipment->top_qtr_inches = $request->top_qtr_inches;
		$shipment->bot_feet = $request->bot_feet;
		$shipment->bot_inches = $request->bot_inches;
		$shipment->bot_qtr_inches = $request->bot_qtr_inches;
		$shipment->obs_temp = $request->obs_temp;
		$shipment->top_temp = $request->top_temp;
		$shipment->bot_temp = $request->bot_temp;
		$shipment->obs_gravity = $request->obs_gravity;
		$shipment->bsw = $request->bsw;
		$shipment->split_load = $request->split_load;
		$shipment->rejected_load = $request->reject_load;
		$shipment->demm_hrs = $request->demm_hrs;
		$shipment->demm_reason = $request->demm_reason;
		$shipment->chain_up = $request->chain_up;
		$shipment->masking_up = $request->masking_up;
		$shipment->notes = $request->notes;

		$shipment->created_by = Auth::user()->id;
		$shipment->updated_by = Auth::user()->id;

		$shipment->save();

		return redirect()->route('admin.shipments.show', ['id'=>$id])->with('success', 'Successfully Edited Shipment');
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

	/**
	 * Run some ajax depending on the request parameters
	 * @param  \Illuminate\Http\Request  $request
	 * @return text/json
	 */
	public function postAjaxRequest(Request $request)
	{
		if(isset($request->lease_id) && isset($request->depot_id)) {
			$mileage = LeaseMileage::where('depot_id', '=', $request->depot_id)->where('lease_id', '=', $request->lease_id)->get();
			if(count($mileage)>0) {
				return $mileage;
			} else {
				return "No Mileage";
			}
		} elseif(isset($request->lease_id)) {
			// Return the rate depending on the lease chosen.
			$lease = Lease::find($request->lease_id);

			if(!empty($lease->billing_office_id)) {
				$return['rates'] = $lease->billing_office->rates;
			} else {
				$return['rates'] = 'No Rates';
			}

			if(!empty($lease->operator_id)) {
				$return['operator'] = $lease->operator;
			} else {
				$return['operator'] = 'No Operator';
			}

			if(count($lease->tanks)>0) {
				$return['tanks'] = $lease->tanks;
			} else {
				$return['tanks'] = 'No Tanks';
			}

			return $return;
		} elseif(isset($request->depot_id)) {
			// Return the headers depending on the depot chosen
			$depot = Depot::find($request->depot_id);
			if(!empty($depot)) {
				return $depot->headers;
			} else {
				return "No Headers";
			}
		} elseif(isset($request->rate_id)) {
			// Return the rate details depending on the rate chosen
			$rate = Rate::find($request->rate_id);
			if(!empty($rate)) {
				return $rate;
			} else {
				return "No Rate Values";
			}
		} else {
			return "No Success";
		}
	}
}
