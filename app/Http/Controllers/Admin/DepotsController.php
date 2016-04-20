<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Depot;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DepotsController extends Controller
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
		
		$depots = Depot::where('account_id', $currentUser->account->id)->get();

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
							null,
						]
					});

					var globals = {};

					$('.sa-warning').click(function(e){
						globals['id'] = $(this).data('depot-id');
						e.stopPropagation();
						swal({
							title: \"Are you sure?\",
							text: \"You will not be able to recover this depot!\",
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
							$.post('/admin/depots/'+globals.id, {_method: 'DELETE', _token: token}, function(data, textStatus, xhr) {
								console.log(data);
								if(data==\"success\"){
									swal({
										title:\"Deleted!\",
										text: \"Depot has been deleted.\",
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
			'depots' => $depots,
		];

		return view('admin.depots.index', $viewParams);
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

		return view('admin.depots.create', $viewParams);
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
			'code' => 'required|unique:depots',
			'name' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$depot = new Depot();

		$depot->account_id = Auth::user()->account->id;
		$depot->code = $request->code;
		$depot->name = $request->name;
		$depot->latitude = $request->latitude;
		$depot->longitude = $request->longitude;

		$depot->created_by = Auth::user()->id;
		$depot->updated_by = Auth::user()->id;

		$depot->save();

		return redirect()->route('admin.depots.index')->with('success', 'Successfully Created Depot!');
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

		$depot = Depot::find($id);
		$headers = $depot->headers;
		$allocations = $depot->allocations;

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js\"></script>
			<script src=\"//cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script src=\"/js/depots/show.js\"></script>
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
			'depot' => $depot,
			'headers' => $headers,
			'allocations' => $allocations,
		];

		return view('admin.depots.show', $viewParams);
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

		$depot = Depot::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'depot' => $depot,
		];

		return view('admin.depots.edit', $viewParams);
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

		$depot = Depot::find($id);

		if($request->code != $depot->code) $validateCode = 'required|unique:depots';
		else $validateCode = 'required'; 

		$this->validate($request, [
			'code' => $validateCode,
			'name' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$depot->account_id = Auth::user()->account->id;
		$depot->code = $request->code;
		$depot->name = $request->name;
		$depot->latitude = $request->latitude;
		$depot->longitude = $request->longitude;

		$depot->updated_by = Auth::user()->id;

		$depot->save();

		return redirect()->route('admin.depots.show', ['id'=>$id])->with('success', 'Successfully Edited Depot');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return text
	 */
	public function destroy($id)
	{
		$depot = Depot::findOrFail($id);

		$depot->delete();

		return "success";
	}
}
