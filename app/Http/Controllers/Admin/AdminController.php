<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Account;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

	public function __construct()
	{
		$this->middleware('timeout');
	}

	/**
	 * Display the main dashboard
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDashboard() {

		$currentUser = Auth::user();
		$currentUser->account = Account::where('id', $currentUser->account_id)->first();

		$scripts = '
			<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
			<script src="/plugins/datatables/dataTables.bootstrap.js"></script>
			<script src="/js/dashboard/index.js"></script>
		';

		$styles = '
			<link href="/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
			<link href="/css/dashboard.css" rel="stylesheet" type="text/css">
		';

		$viewParams = [
			'scripts' => $scripts,
			'styles' => $styles,
			'currentUser' => $currentUser
		];

		return view('admin.dashboard', $viewParams);
	}
}
