<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdspaceImages;
use App\Models\Admin\ResourceModel;
use Illuminate\Http\Request;

class ResourcesWebController extends Controller
{

    public function index(Request $request, NetworkWebController $nwc)
    {
        // fetch all request from networks page when user click
        $filters = $request->all();
        // get ad image 
        $adspace_image = $nwc->get_adspaces();
        // get web logo 
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();

        $resources = $this->get_resources(0);
        // dd($resources);
        // Get top networks
        $top_networks =  $nwc->get_top_networks();
        //  get featured networks
        $featured_networks =  $nwc->get_featured_networks();

        return view('web.pages.resources.resources', [
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'adspace_image' => $adspace_image,
            'resources' => $resources,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            'filters' => $filters,
        ]);
    }
    // get title,subtitle and subchild to resources page
    public function get_resources($parent_id = 0)
    {
        $select = [];
        $select[] = "id";
        $select[] = "categories_title";
        $select[] = "parent_id";
        $select[] = "link";
        $select[] = "status";
        $select[] = "description";
        $childCategories = ResourceModel::select($select)->where('parent_id', $parent_id)->get()->toArray();
        // get child
        foreach ($childCategories as $key => $category) {
            $subChildren = $this->get_resources($category['id']);
            $childCategories[$key]['child'] = $subChildren;
        }
        return $childCategories;
    }
}
