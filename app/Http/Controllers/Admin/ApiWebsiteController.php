<?php

namespace App\Http\Controllers\Admin;

use App\Models\Website;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Http\Request;

class ApiWebsiteController extends AdminController
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

	public function get($websiteId)
	{
		$website = Website::find($websiteId);
		if(empty($website)) {
			abort(404);
		}
		$factory = new WebsiteFactory($website);
		return [
			'success' => true,
			'website' => $factory->getWebsiteData()
		];
	}

	public function save(Request $request, $websiteId)
	{
		$website = Website::find($websiteId);
		if(empty($website)) {
			abort(404);
		}
		$factory = new WebsiteFactory($website);
		$result = $factory->save($request);
		return [
			'success' => $result,
			'errors' => $factory->errors,
			'website' => $factory->getWebsiteData()
		];
	}

	public function add(Request $request)
	{
		$website = new Website();
		$factory = new WebsiteFactory($website);
		if ($factory->create($request)) {
			return [
				'success' => true,
				'redirectUrl' => '/admin/website/edit/' . $factory->website->id,
			];
		}
		return [
			'success' => false,
			'errors' => $factory->errors
		];
	}
	/**
	 * Regenerate website pages
	 *
	 * @return array
	 */
	public function regeneratePages($websiteId)
	{
		$website = Website::find($websiteId);
		if(empty($website)) {
			abort(404);
		}
		$factory = new WebsiteFactory($website);
		return [
			'success' => $factory->page->regeneratePages(),
			'errors' => $factory->errors,
			'website' => $factory->getWebsiteData()
		];
	}
}
