<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Operator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OperatorsController extends Controller
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
		
		// Since Operators are assigned to Customers, and not the Account themselves,
		// we have to grab all the Customers first, then run a loop to get the Operators.
		// OR as in below, we run a left join to get all the Operators in one query.
		DB::enableQueryLog();
		$operators = Operator::leftJoin('customers', 'operators.customer_id', '=', 'customers.id')
			->where('customers.account_id', $currentUser->account->id)
			->select('operators.*')->get();
		// dd(DB::getQueryLog());

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script>
				$(document).ready(function() {
					$('#datatable').DataTable({
						order: [
							[1, 'asc']
						],
						columns: [
							{ orderable: false },
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
			'operators' => $operators,
			'tab' => 'operators',
		];

		return view('admin.operators.index', $viewParams);
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
			'tab' => 'operators',
		];

		return view('admin.operators.create', $viewParams);
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
		]);

		$operator = new Operator();

		$operator->name = $request->name;
		$operator->customer_id = $request->customer;

		$operator->created_by = Auth::user()->id;
		$operator->updated_by = Auth::user()->id;

		$operator->save();

		return redirect()->route('admin.operators.index')->with('success', 'Successfully created operator!');
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

		$operator = Operator::find($id);

		$scripts = "
			<script>
			$(document).ready(function() {
				$('#sa-warning').click(function(){
					swal({
						title: \"Are you sure?\",
						text: \"You will not be able to recover this operator!\",
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
			'operator' => $operator,
			'tab' => 'operators',
		];

		return view('admin.operators.show', $viewParams);
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

		$operator = Operator::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'operator' => $operator,
			'tab' => 'operators',
		];

		return view('admin.operators.edit', $viewParams);
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
			'customer' => 'required',
		]);

		$operator = Operator::find($id);

		$operator->name = $request->name;
		$operator->customer_id = $request->customer;

		$operator->updated_by = Auth::user()->id;

		$operator->save();

		return redirect()->route('admin.operators.show', ['id'=>$id]);
	}

	/**
	 * Soft delete the Operator
	 *
	 * @param  int  $id
	 * @return text/json
	 */
	public function destroy($id)
	{
		$operator = Operator::findOrFail($id);

		$operator->delete();

		return "success";
	}
}
