<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Driver;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DriversController extends Controller
{

	public function __construct()
	{
		$this->middleware('timeout');
	}

	/**
	 * Display users index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$currentUser = Auth::user();
		
		$drivers = Driver::where('account_id', $currentUser->account->id)->get();

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script>
				$(document).ready(function() {
					$('#datatable').DataTable({
						order: [
							[3, 'desc']
						],
						columns: [
							{ orderable: false },
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
			'drivers' => $drivers,
		];

		return view('admin.drivers.index', $viewParams);
	}

	/**
	 * Show the form for creating a new user.
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

		return view('admin.drivers.create', $viewParams);
	}

	/**
	 * Store a newly created user in the database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'firstname' => 'required',
			'lastname' => 'required',
			'rate' => 'required',
			'ssnlast4' => 'required',
		]);

		$driver = new Driver();

		$driver->account_id = Auth::user()->account->id;
		$driver->firstname = $request->firstname;
		$driver->lastname = $request->lastname;
		$driver->rate = $request->rate;
		$driver->ssnlast4 = $request->ssnlast4;

		$driver->created_by = Auth::user()->id;
		$driver->updated_by = Auth::user()->id;

		$driver->save();

		return redirect()->route('admin.drivers.index')->with('success', 'Successfully created driver!');
	}

	/**
	 * Display the user details.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$currentUser = Auth::user();

		$driver = Driver::find($id);

		$scripts = "
			<script>
			$(document).ready(function() {
				$('#sa-warning').click(function(){
					swal({
						title: \"Are you sure?\",
						text: \"You will not be able to recover this driver!\",
						type: \"warning\",
						showCancelButton: true,
						confirmButtonColor: \"#DD6B55\",
						confirmButtonText: \"Yes, delete it!\",
						closeOnConfirm: false 
					}, function(){
						swal({
							title:\"Deleted!\",
							text: \"Driver has been deleted.\",
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
			'driver' => $driver,
		];

		return view('admin.drivers.show', $viewParams);
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

		$driver = Driver::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'driver' => $driver,
		];

		return view('admin.drivers.edit', $viewParams);
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
			'firstname' => 'required',
			'lastname' => 'required',
			'company' => 'required',
			'email' => 'required|email',
			'role' => 'required',
		]);

		$currentUser = Auth::user();
		$user = User::find($id);

		$user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->account_id = $request->company;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->role = $request->role;
		$user->description = $request->description;

		$user->updated_by = $currentUser->id;

		$user->save();

		return redirect()->route('admin.users.show', ['id'=>$id])->with('success', 'Successfully updated user!');
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
