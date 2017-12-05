<?php

namespace App\Http\Controllers\Admin;

use App\Models\Website;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Http\Request;

class WebsiteController extends AdminController
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		if ($this->domain !== config('app.domain')) {
			abort(404);
		}
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$websites = Website::all();
		return view('admin.website.list', [
			'websites' => $websites
		]);
	}

	public function edit($websiteId)
	{
		$website = Website::find($websiteId);
		if(empty($website)) {
			abort(404);
		}
		return view('admin.website.edit', [
			'website' => $website
		]);
	}

	public function add()
	{
		return view('admin.website.add');
	}
}
