<?php
namespace App\Services\Generator;

use App\Models\Website;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: ben
 * Date: 02/12/2017
 * Time: 00:15
 */
class WebsiteFactory {
	public $website;
	public $page;
	public $template;
	public $menu;
	public $errors = [];

	public function __construct(Website $website)
	{
		$this->website = $website;
		$this->page = new PageFactory($this);
		$this->template = new TemplateFactory($this);
		$this->menu = new MenuFactory($this);
	}

	/**
	 * @param Request $request
	 * @return bool
	 */
	public function save(Request $request)
	{
		$websiteData = $request->get('website');
		foreach ($websiteData as $key=>$value) {
			if(in_array($key,['name', 'domain', 'is_publish', 'template_id'])) {
				$this->website->setAttribute($key, $value);
			}
		}
		return $this->website->save();
	}

	/**
	 * @param Request $request
	 * @return bool
	 */
	public function create(Request $request)
	{
		$websiteData = $request->get('website');
		foreach ($websiteData as $key=>$value) {
			if(in_array($key,['name', 'domain', 'template_id'])) {
				$this->website->setAttribute($key, $value);
			}
		}
		return $this->website->save();
	}

	public function getWebsiteData()
	{
		$websiteData = $this->website->toArray();
		$websiteData['pages'] = $this->page->getPageData();
		return $websiteData;
	}

	public function renderWebsiteTitle()
	{
		return $this->website->name;
	}

	public function getTemplateName()
	{
		return "simple";
	}

	public function renderWidgetBlock($blockName)
	{
		return "";
	}
}