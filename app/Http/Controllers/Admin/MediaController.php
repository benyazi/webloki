<?php
namespace App\Http\Controllers\Admin;
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 02.02.18
 * Time: 17:27
 */

use App\Models\Page;
use App\Models\Website;
use App\Services\Generator\WebsiteFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class MediaController extends AdminController
{

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

    public function index()
    {
        return view('admin.website.media.list');
    }

}