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

	public function render($config = [])
	{
		return view('blocks.menu.' . $config['template'], [
			'websiteFactory' => $this->websiteFactory,
            'config' => $config
		]);
	}

	public function renderLogoBlock()
	{
	    $media = $this->websiteFactory->website->getFirstMedia('logo');
	    if(empty($media)) {
            return $this->websiteFactory->website->name;
        } else {
	        return '<img src="' . $media->getUrl() . '">';
        }
	}

}