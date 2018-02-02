<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Models\Website;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use View;

class MediaController extends AdminController
{
    const COLLECTIONS = [
                ['id' => null, 'name' => 'all'],
                ['id' => 1, 'name' => 'default'],
                ['id' => 2, 'name' => 'gallery1'],
                ['id' => 3, 'name' => 'logo'],
                ['id' => 4, 'name' => 'mainImage'],
            ];
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

	public function get()
	{
		$files = $this->editWebsiteFactory->getMediaFiles();
		return [
			'success' => true,
			'files' => $files,
            'collections' => self::COLLECTIONS
		];
	}

    public function upload(Request $request)
    {
        $files = $request->file('attachments');
        $collection = $request->get('collection', 'default');
        $errors = [];
        foreach ($files as $file) {
            try {
                $this->editWebsiteFactory->website->addMedia($file)->toMediaCollection($collection);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
        return [
            'success' => (count($errors))?false:true,
            'files' => $this->editWebsiteFactory->getMediaFiles(),
            'errors' => $errors
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
