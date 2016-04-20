<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Hash;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

	public function __construct()
	{
		$this->middleware('timeout');
		$this->middleware('rolecheck.users');
	}

	/**
	 * Display users index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$currentUser = Auth::user();
		
		$users = User::get();

		$scripts = "
			<script src=\"/plugins/datatables/jquery.dataTables.min.js\"></script>
			<script src=\"/plugins/datatables/dataTables.bootstrap.js\"></script>
			<script>
				$(document).ready(function() {
					$('#datatable').DataTable({
						order: [
							[4, 'desc']
						],
						columns: [
							{ orderable: false },
							null,
							null,
							null,
							{ width: '10%' },
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
			'users' => $users,
		];

		if($currentUser->role!='Admin' && $currentUser->role!='Owner' && $currentUser->role!='Manager') return redirect()->route('dashboard')->with('failure', 'You are not authorized to access this area');
		else return view('admin.users.index', $viewParams);
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

		return view('admin.users.create', $viewParams);
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
			'company' => 'required',
			'email' => 'required|email',
			'role' => 'required',
			'username' => 'required|unique:users',
			'password' => 'required',
		]);

		$user = new User();

		$user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->account_id = $request->company;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->role = $request->role;
		$user->description = $request->description;
		$user->username = $request->username;
		$user->password = Hash::make($request->password);

		$user->created_by = Auth::user()->id;

		$user->save();

		return redirect()->route('admin.users.index')->with('success', 'Successfully created user!');
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

		$user = User::find($id);

		$scripts = "
			<script>
			$(document).ready(function() {
				$('#sa-warning').click(function(){
					swal({
						title: \"Are you sure?\",
						text: \"You will not be able to recover this user!\",
						type: \"warning\",
						showCancelButton: true,
						confirmButtonColor: \"#DD6B55\",
						confirmButtonText: \"Yes, delete it!\",
						closeOnConfirm: false 
					}, function(){
						swal({
							title:\"Deleted!\",
							text: \"User has been deleted.\",
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
			'user' => $user,
		];

		return view('admin.users.show', $viewParams);
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

		$user = User::find($id);

		$viewParams = [
			'styles' => '',
			'scripts' => '',
			'currentUser' => $currentUser,
			'user' => $user,
		];

		return view('admin.users.edit', $viewParams);
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
