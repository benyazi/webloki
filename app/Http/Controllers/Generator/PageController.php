<?php

namespace App\Http\Controllers\Generator;

use App\Models\Website;
use View;
use Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	const MAIN_PAGE_SLUG = 'main';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function view(Request $request, $pageSlug = self::MAIN_PAGE_SLUG)
	{
		if(empty($this->website)) {
			return redirect()->action('Generator\PageController@notFoundPage', ['pageSlug' => $pageSlug]);
		}
		if($this->websiteFactory->page->setActivePage($pageSlug)) {
            return view('generator.website.page');
        }
        abort(404);
	}

	public function notFoundPage($pageSlug = self::MAIN_PAGE_SLUG)
	{
		return view('generator.website.404', [
			'pageSlug' => $pageSlug
		]);
	}
}
