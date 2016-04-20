<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Depot;
use App\DepotAllocation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DepotAllocationsController extends Controller
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
		
		// Since Depot Allocations are assigned to Depots, and not the Account themselves,
		// we have to grab all the Depots first, then run a loop to get the Allocations.
		// OR as in below, we run a select within the select to get all the Allocations in one query.
		DB::enableQueryLog();
		$allocations = DepotAllocation::leftJoin('depots', 'depot_allocations.depot_id', '=', 'depots.id')->where('depots.account_id', $currentUser->account->id)->select('depot_allocations.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js\"></script>
			<script src=\"//cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script>
				$(document).ready(function() {
					$.fn.dataTable.moment( 'MM/YYYY' );
					$.fn.dataTable.moment( 'MM/D/YYYY' );
					$('#datatable').DataTable({
						order: [
							[4, 'asc']
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

					var globals = {};

					$('.sa-warning').click(function(e){
						globals['id'] = $(this).data('allocation-id');
						e.stopPropagation();
						swal({
							title: \"Are you sure?\",
							text: \"You will not be able to recover this Allocation!\",
							type: \"warning\",
							showCancelButton: true,
							confirmButtonColor: \"#DD6B55\",
							confirmButtonText: \"Yes, delete it!\",
							closeOnConfirm: false 
						}, function(){
							console.log(globals.id);
							console.log('Clicked Yes');
							var token = $('#token').data('token');
							console.log(token);
							$.post('/admin/allocations/'+globals.id, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
								console.log(data);
								if(data==\"success\"){
									swal({
										title:\"Deleted!\",
										text: \"Depot Allocation has been deleted.\",
										type: \"success\"
									}, function() {
										window.location.href = '/admin/allocations';
									});
								} else {
									swal({
										title:\"Error!\",
										text: \"Unfortunately, an error occured. Please try again, or contact the web administrator.\",
										type: \"error\"
									});	
								}
							});
						});
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
			'allocations' => $allocations,
		];

		return view('admin.allocations.index', $viewParams);
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

		return view('admin.allocations.create', $viewParams);
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
				'depot_id' => 'required',
				'bbls' => 'required|integer',
				'bbls_revised' => 'required|integer',
				'month_year' => 'required',
			]);
		}

		$header = new DepotAllocation();

		if($request->ajax()) {
			$header->depot_id = $request->params['depot_id'];
			$header->bbls = $request->params['bbls'];
			$header->bbls_revised = $request->params['bbls_revised'];
			$header->month_year = $request->params['month_year'];
			$header->comments = $request->params['comments'];
		} else {
			$header->depot_id = $request->depot_id;
			$header->bbls = $request->bbls;
			$header->bbls_revised = $request->bbls_revised;
			$header->month_year = $request->month_year;
			$header->comments = $request->comments;
		}

		$header->created_by = Auth::user()->id;
		$header->updated_by = Auth::user()->id;

		$header->save();

		if($request->ajax()) return response()->json(['responseText' => 'Success!'], 200);
		else return redirect()->route('admin.allocations.index')->with('success', 'Successfully Created Depot Allocation!');
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

		$allocation = DepotAllocation::find($id);

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
					]
				});

				$('#datatable2').DataTable({
					order: [
						[1, 'desc']
					],
					columns: [
						{ orderable: false },
						null,
						null,
						null,
					]
				});

				$('#sa-warning').click(function(){
					swal({
						title: \"Are you sure?\",
						text: \"You will not be able to recover this Depot Allocation!\",
						type: \"warning\",
						showCancelButton: true,
						confirmButtonColor: \"#DD6B55\",
						confirmButtonText: \"Yes, delete it!\",
						closeOnConfirm: false 
					}, function(){
						console.log('Clicked Yes');
						var token = $('#sa-warning').data('token');
						console.log(token);
						$.post(window.location.href, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
							console.log(data);
							if(data==\"success\"){
								swal({
									title:\"Deleted!\",
									text: \"Depot Allocation has been deleted.\",
									type: \"success\"
								}, function() {
									window.location.href = '/admin/allocations';
								});
							} else {
								swal({
									title:\"Error!\",
									text: \"Unfortunately, an error occured. Please try again, or contact the web administrator.\",
									type: \"error\"
								});	
							}
						});
					});
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
			'allocation' => $allocation,
		];

		return view('admin.allocations.show', $viewParams);
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

		$allocation = DepotAllocation::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'allocation' => $allocation,
		];

		return view('admin.allocations.edit', $viewParams);
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

		$allocation = DepotAllocation::find($id);

		$this->validate($request, [
			'depot_id' => 'required',
			'bbls' => 'required|integer',
			'bbls_revised' => 'required|integer',
			'month_year' => 'required',
		]);

		$allocation->depot_id = $request->depot_id;
		$allocation->bbls = $request->bbls;
		$allocation->bbls_revised = $request->bbls_revised;
		$allocation->month_year = $request->month_year;

		$allocation->updated_by = Auth::user()->id;

		$allocation->save();

		return redirect()->route('admin.allocations.show', ['id'=>$id])->with('success', 'Successfully Edited Depot Allocation');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return text
	 */
	public function destroy($id)
	{
		$allocation = DepotAllocation::findOrFail($id);

		$allocation->delete();

		return "success";
	}
}
