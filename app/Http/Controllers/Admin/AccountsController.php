<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Account;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{

	public function __construct()
	{
		$this->middleware('timeout');
		$this->middleware('rolecheck.accounts');
	}

	/**
	 * Display accounts index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$currentUser = Auth::user();
		
		$accounts = Account::get();

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
							null
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
			'accounts' => $accounts,
		];

		if($currentUser->role!='Admin') return redirect('/admin/dashboard')->with('failure', 'You are not authorized to access this area');
		else return view('admin.accounts.index', $viewParams);
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

		return view('admin.accounts.create', $viewParams);
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
			'owner' => 'required',
		]);

		$account = new Account();

		$account->name = $request->name;
		$account->owner = $request->owner;
		$account->contact_name = $request->contact_name;
		$account->contact_email = $request->contact_email;
		$account->contact_phone = $request->contact_phone;
		$account->address = $request->address;
		$account->city = $request->city;
		$account->state = $request->state;
		$account->zip_code = $request->zip_code;

		$account->created_by = Auth::user()->id;

		$account->save();

		return redirect()->route('admin.accounts.index')->with('success', 'Successfully created account!');
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

		$account = Account::find($id);

		$scripts = "
			<script>
			$(document).ready(function() {
				$('#sa-warning').click(function(){
					swal({
						title: \"Are you sure?\",
						text: \"You will not be able to recover this account!\",
						type: \"warning\",
						showCancelButton: true,
						confirmButtonColor: \"#DD6B55\",
						confirmButtonText: \"Yes, delete it!\",
						closeOnConfirm: false 
					}, function(){
						swal({
							title:\"Deleted!\",
							text: \"Account has been deleted.\",
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
			'account' => $account,
		];

		return view('admin.accounts.show', $viewParams);
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

		$account = Account::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'account' => $account,
		];

		return view('admin.accounts.edit', $viewParams);
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
		$currentUser = Auth::user();
		$account = Account::find($id);

		$account->name = $request->name;
		$account->owner = $request->owner;
		$account->contact_name = $request->contact_name;
		$account->contact_email = $request->contact_email;
		$account->contact_phone = $request->contact_phone;
		$account->address = $request->address;
		$account->city = $request->city;
		$account->state = $request->state;
		$account->zip_code = $request->zip_code;

		$account->updated_by = $currentUser->id;

		$account->save();

		return redirect()->route('admin.accounts.show', ['id'=>$id]);
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
}
