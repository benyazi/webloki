<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\WebsiteController;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Request;
use View;
use App\Models\Website;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public $domain;
	public $website;
	public $websiteFactory;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->domain = preg_replace('#^https?://#', '', Request::root());
		$this->website = Website::query()
			->where('domain', $this->domain)
			->where('is_publish', true)
			->first();
		if(!empty($this->website)) {
			$this->websiteFactory = new WebsiteFactory($this->website);
			View::share ( 'websiteFactory', $this->websiteFactory );
		}
	}
}
