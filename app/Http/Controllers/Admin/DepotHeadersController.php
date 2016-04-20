<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Depot;
use App\DepotHeader;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DepotHeadersController extends Controller
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
		
		// Since Depot Headers are assigned to Depots, and not the Account themselves,
		// we have to grab all the Depots first, then run a loop to get the Headers.
		// OR as in below, we run a select within the select to get all the headers in one query.
		DB::enableQueryLog();
		$headers = DepotHeader::leftJoin('depots', 'depot_headers.depot_id', '=', 'depots.id')->where('depots.account_id', $currentUser->account->id)->select('depot_headers.*')->get();
		// dd(DB::getQueryLog());

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

					var globals = {};

					$('.sa-warning').click(function(e){
						globals['id'] = $(this).data('header-id');
						e.stopPropagation();
						swal({
							title: \"Are you sure?\",
							text: \"You will not be able to recover this header!\",
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
							$.post('/admin/headers/'+globals.id, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
								console.log(data);
								if(data==\"success\"){
									swal({
										title:\"Deleted!\",
										text: \"Depot Header has been deleted.\",
										type: \"success\"
									}, function() {
										window.location.href = '/admin/headers';
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
			'headers' => $headers,
		];

		return view('admin.headers.index', $viewParams);
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

		return view('admin.headers.create', $viewParams);
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
				'name' => 'required',
				'owner' => 'required',
			]);
		}

		$header = new DepotHeader();

		if($request->ajax()) {
			$header->depot_id = $request->params['depot_id'];
			$header->owner = $request->params['owner'];
			$header->name = $request->params['name'];
		} else {
			$header->depot_id = $request->depot_id;
			$header->owner = $request->owner;
			$header->name = $request->name;
		}

		$header->created_by = Auth::user()->id;
		$header->updated_by = Auth::user()->id;

		$header->save();

		if($request->ajax()) return response()->json(['responseText' => 'Success!'], 200);
		else return redirect()->route('admin.headers.index')->with('success', 'Successfully Created Depot Header!');
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

		$header = DepotHeader::find($id);

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
						text: \"You will not be able to recover this Depot Header!\",
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
									text: \"Depot Header has been deleted.\",
									type: \"success\"
								}, function() {
									window.location.href = '/admin/depots';
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
			'header' => $header,
		];

		return view('admin.headers.show', $viewParams);
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

		$header = DepotHeader::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'header' => $header,
		];

		return view('admin.headers.edit', $viewParams);
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

		$header = DepotHeader::find($id);

		$this->validate($request, [
			'depot_id' => 'required',
			'name' => 'required',
			'owner' => 'required',
		]);

		$header->depot_id = $request->depot_id;
		$header->owner = $request->owner;
		$header->name = $request->name;

		$header->updated_by = Auth::user()->id;

		$header->save();

		return redirect()->route('admin.headers.show', ['id'=>$id])->with('success', 'Successfully Edited Depot Header');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return text
	 */
	public function destroy($id)
	{
		$header = DepotHeader::findOrFail($id);

		$header->delete();

		return "success";
	}
}
