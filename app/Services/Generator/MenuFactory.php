<?php
namespace App\Services\Generator;

use App\Models\Website;

/**
 * Created by PhpStorm.
 * User: ben
 * Date: 02/12/2017
 * Time: 00:15
 */
class MenuFactory {
	public $websiteFactory;

	public function __construct(WebsiteFactory $websiteFactory)
	{
		$this->websiteFactory = $websiteFactory;
	}

	public function render()
	{
		return view('blocks.menu.simple', [
			'websiteFactory' => $this->websiteFactory
		]);
	}

	public function renderLogoBlock()
	{
		return $this->websiteFactory->website->name . " logo";
	}

}