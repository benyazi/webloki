<?php
namespace App\Services\Generator;

use App\Models\Website;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

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
	    $title = $this->website->name;
	    $title .= ' - ' . $this->page->activePage->title;
		return $title;
	}

	public function getTemplateName()
	{
		return $this->website->template->name;
	}

	public function getMediaUrl($mediaId)
    {
        $media = Media::find($mediaId);
        if(empty($media)) {
            return '/nofound.jpg';
        }
        return $media->getUrl();
    }

	public function getMediaUrlFirstFromCollection($collection)
    {
        $media = $this->website->getFirstMedia($collection);
        if(empty($media)) {
            return '/nofound.jpg';
        }
        return $media->getUrl();
    }

    public function getRandomImages()
    {
        $files = Media::query()
            ->where('model_type', Website::class)
            ->where('model_id', $this->website->id)
            ->limit(6)
            ->orderBy('id','desc')
            ->get();
        return $files;
    }

    public function getServices()
    {
        return $this->website->services()->get();
    }

    public function getMainServices($limit = null)
    {
        return $this->website->services()
            ->where('is_main', true)
            ->limit($limit)
            ->get();
    }

	public function getMediaFiles()
    {
        $files = [];
        $mediaFiles = Media::query()
            ->where('model_type', Website::class)
            ->where('model_id', $this->website->id)
            ->get();
        foreach ($mediaFiles as $media) {
            $files[] = [
                'id' => $media->id,
                'name' => $media->name,
                'collection' => $media->collection_name,
                'thumb' => $media->getUrl()
            ];
        }
        return $files;
    }

	public function getAssertPath() {
	    return '/asserts/' . $this->getTemplateName() . '/';
    }

	public function renderWidgetBlock($blockName)
	{
		return "";
	}
}