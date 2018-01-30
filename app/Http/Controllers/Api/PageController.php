<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Models\Website;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class PageController extends AdminController
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

	public function get($pageId)
	{
		$page = Page::find($pageId);
		if(empty($page)) {
			abort(404);
		}
		return [
			'success' => true,
			'page' => $page->toArray()
		];
	}

	public function update(Request $request)
	{
	    $pageData = (array) $request->get('page');
		$page = Page::find($pageData['id']);
		if(empty($page)) {
			abort(404);
		}
        $page->fill($pageData);
        if ($page->save()) {
            return [
                'success' => true,
                'redirectUrl' => '/admin/website/' . $page->website_id . '/page/edit/' . $page->id,
            ];
        }
        return [
            'success' => false,
            'errors' => []
        ];
	}

	public function add(Request $request)
	{
		$page = new Page();
		$page->fill((array) $request->get('page'));
		if ($page->save()) {
			return [
				'success' => true,
				'redirectUrl' => '/admin/website/' . $page->website_id . '/page/edit/' . $page->id,
			];
		}
		return [
			'success' => false,
			'errors' => []
		];
	}
}
