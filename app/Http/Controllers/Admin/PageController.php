<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Website;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class PageController extends AdminController
{
    protected $editWebsiteFactory;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		parent::__construct();
		if ($this->domain !== config('app.domain')) {
			abort(404);
		}
        $websiteId = $request->route()->parameter('websiteId');
		if(empty($websiteId)) {
		    abort(403);
        }
        $website = Website::find($websiteId);
        if(empty($website)) {
            abort(404);
        }
        $this->editWebsiteFactory = new WebsiteFactory($website);
        View::share ( 'editWebsiteFactory', $this->editWebsiteFactory );
	}

	/**
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.website.page.list', [

        ]);
	}

	public function edit(Request $request, $websiteId, $pageId)
	{
		$page = Page::query()
            ->where('website_id', $websiteId)
            ->where('id', $pageId)
            ->first();
		if(empty($page)) {
			abort(404);
		}
		return view('admin.website.page.edit', [
			'page' => $page
		]);
	}

	public function add()
	{
		return view('admin.website.page.add');
	}
}
