<?php
namespace App\Services\Generator;

use App\Models\Page;
use App\Models\Website;
use Markdown;

/**
 * Created by PhpStorm.
 * User: ben
 * Date: 02/12/2017
 * Time: 00:15
 */
class PageFactory {
	public $websiteFactory;
	public $activePage;

	public function __construct(WebsiteFactory $websiteFactory)
	{
		$this->websiteFactory = $websiteFactory;
	}

	public function getList()
	{
		$pages = $this->websiteFactory->website->pages();
		$pages = $pages->orderBy('menu_position');
		return $pages->get();
	}

	public function setActivePage($pageSlug)
	{
		$pages = $this->websiteFactory->website->pages();
		$pages = $pages->where('slug', $pageSlug);
		$page = $pages->first();
		if(!empty($page)) {
			$this->activePage = $page;
			return true;
		}
		return false;
	}

	public function getActiveHtmlContent()
    {
        $content = $this->activePage->content;
        $content = Markdown::convertToHtml($content);
        return $content;
    }

	public function getPageData()
	{
		$pageData = [];
		foreach ($this->websiteFactory->website->pages()->get() as $page) {
			$pageData[] = $page->toArray();
		}
		return $pageData;
	}

	public function regeneratePages()
	{
		foreach ($this->websiteFactory->website->pages()->get() as $page) {
			/**
			 * @var Page $page
			 */
			$page->delete();
		}
		$tempPages = [
			['slug' => 'main', 'title' => 'Главная', 'content' => 'Текст главной страницы'],
			['slug' => 'services', 'title' => 'Услуги', 'content' => 'Текст страницы с услугами'],
			['slug' => 'contacts', 'title' => 'Контакты', 'content' => 'Текст страницы с контактной информацией'],
		];
		$position = 1;
		foreach ($tempPages as $tempPage) {
			$page = new Page();
			foreach ($tempPage as $key => $value) {
				$page->setAttribute($key,$value);
			}
			$page->setAttribute('menu_position', $position);
			$position++;
			$page->setAttribute('website_id', $this->websiteFactory->website->id);
			$page->save();
		}
		return true;
	}

}