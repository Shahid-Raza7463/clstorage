<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\ContactInfo;
use App\Models\Portfolio\PortfolioCategory;
use App\Models\Portfolio\PortfolioItem;
use App\Models\Portfolio\PortfolioProfile;
use App\Models\Portfolio\PortfolioStat;
use App\Models\Portfolio\ResumeItem;
use App\Models\Portfolio\ResumeSection;
use App\Models\Portfolio\Service;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\SocialLink;
use App\Models\Portfolio\Testimonial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioContentController extends Controller
{
    private array $resources = [
        'settings' => [
            'title' => 'Portfolio Settings',
            'model' => PortfolioProfile::class,
            'fields' => ['name', 'title', 'typed_items', 'profile_image', 'hero_image', 'about_image', 'about_summary', 'about_description', 'about_extra_description', 'birthday', 'website', 'phone', 'city', 'age', 'degree', 'email', 'freelance', 'skills_intro', 'resume_intro', 'portfolio_intro', 'contact_intro', 'map_embed_url'],
            'rules' => ['name' => 'required|string|max:255', 'title' => 'required|string|max:255', 'email' => 'nullable|email'],
        ],
        'social-links' => [
            'title' => 'Social Links',
            'model' => SocialLink::class,
            'fields' => ['portfolio_profile_id', 'name', 'icon_class', 'url', 'sort_order', 'is_active'],
            'rules' => ['name' => 'required|string|max:255', 'icon_class' => 'required|string|max:255', 'url' => 'required|string|max:255'],
        ],
        'skills' => [
            'title' => 'Skills',
            'model' => Skill::class,
            'fields' => ['portfolio_profile_id', 'name', 'percentage', 'sort_order', 'is_active'],
            'rules' => ['name' => 'required|string|max:255', 'percentage' => 'required|integer|min:0|max:100'],
        ],
        'resume-sections' => [
            'title' => 'Resume Sections',
            'model' => ResumeSection::class,
            'fields' => ['portfolio_profile_id', 'name', 'column', 'sort_order', 'is_active'],
            'rules' => ['name' => 'required|string|max:255', 'column' => 'required|in:left,right'],
        ],
        'resume-items' => [
            'title' => 'Resume Items',
            'model' => ResumeItem::class,
            'fields' => ['resume_section_id', 'title', 'period', 'subtitle', 'link_url', 'description', 'bullets', 'sort_order', 'is_active'],
            'rules' => ['resume_section_id' => 'required|exists:resume_sections,id', 'title' => 'required|string|max:255'],
        ],
        'portfolio-categories' => [
            'title' => 'Portfolio Categories',
            'model' => PortfolioCategory::class,
            'fields' => ['name', 'slug', 'sort_order', 'is_active'],
            'rules' => ['name' => 'required|string|max:255', 'slug' => 'nullable|string|max:255'],
        ],
        'portfolio-items' => [
            'title' => 'Portfolio Items',
            'model' => PortfolioItem::class,
            'fields' => ['portfolio_category_id', 'title', 'description', 'image', 'details_url', 'is_mobile', 'sort_order', 'is_active'],
            'rules' => ['portfolio_category_id' => 'nullable|exists:portfolio_categories,id', 'title' => 'required|string|max:255'],
        ],
        'contact-infos' => [
            'title' => 'Contact Info',
            'model' => ContactInfo::class,
            'fields' => ['portfolio_profile_id', 'label', 'value', 'icon_class', 'sort_order', 'is_active'],
            'rules' => ['label' => 'required|string|max:255', 'value' => 'required|string|max:255', 'icon_class' => 'required|string|max:255'],
        ],
        'stats' => [
            'title' => 'Stats',
            'model' => PortfolioStat::class,
            'fields' => ['portfolio_profile_id', 'label', 'description', 'icon_class', 'value', 'sort_order', 'is_active'],
            'rules' => ['label' => 'required|string|max:255', 'icon_class' => 'required|string|max:255', 'value' => 'required|integer|min:0'],
        ],
        'services' => [
            'title' => 'Services',
            'model' => Service::class,
            'fields' => ['portfolio_profile_id', 'title', 'description', 'icon_class', 'details_url', 'sort_order', 'is_active'],
            'rules' => ['title' => 'required|string|max:255', 'description' => 'required|string', 'icon_class' => 'required|string|max:255'],
        ],
        'testimonials' => [
            'title' => 'Testimonials',
            'model' => Testimonial::class,
            'fields' => ['portfolio_profile_id', 'name', 'designation', 'message', 'image', 'sort_order', 'is_active'],
            'rules' => ['name' => 'required|string|max:255', 'message' => 'required|string'],
        ],
    ];

    public function index(string $resource): View
    {
        $config = $this->config($resource);
        $items = $config['model']::latest('id')->paginate(20);

        return view('Admin.portfolio.index', compact('resource', 'config', 'items'));
    }

    public function create(string $resource): View
    {
        $config = $this->config($resource);
        $item = new $config['model'];
        $options = $this->options();

        return view('Admin.portfolio.form', compact('resource', 'config', 'item', 'options'));
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $config = $this->config($resource);
        $data = $this->payload($request, $config);
        $config['model']::create($data);

        return redirect()->route('admin.portfolio.index', $resource)->with('message', 'Data successfully added');
    }

    public function show(string $resource, int $id): View
    {
        $config = $this->config($resource);
        $item = $config['model']::findOrFail($id);

        return view('Admin.portfolio.show', compact('resource', 'config', 'item'));
    }

    public function edit(string $resource, int $id): View
    {
        $config = $this->config($resource);
        $item = $config['model']::findOrFail($id);
        $options = $this->options();

        return view('Admin.portfolio.form', compact('resource', 'config', 'item', 'options'));
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $config = $this->config($resource);
        $item = $config['model']::findOrFail($id);
        $item->update($this->payload($request, $config, $item));

        return redirect()->route('admin.portfolio.index', $resource)->with('message', 'Data successfully updated');
    }

    public function destroy(string $resource, int $id): RedirectResponse
    {
        $config = $this->config($resource);
        $config['model']::findOrFail($id)->delete();

        return redirect()->route('admin.portfolio.index', $resource)->with('message', 'Data successfully deleted');
    }

    private function config(string $resource): array
    {
        abort_unless(isset($this->resources[$resource]), 404);

        return $this->resources[$resource];
    }

    private function payload(Request $request, array $config, ?Model $item = null): array
    {
        $validated = $request->validate($config['rules']);
        $data = $request->only($config['fields']);

        foreach (['is_active', 'is_mobile'] as $field) {
            if (in_array($field, $config['fields'], true)) {
                $data[$field] = $request->boolean($field);
            }
        }

        foreach (['portfolio_profile_id'] as $field) {
            if (in_array($field, $config['fields'], true) && empty($data[$field])) {
                $data[$field] = PortfolioProfile::query()->value('id');
            }
        }

        if (in_array('slug', $config['fields'], true)) {
            $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        }

        if (array_key_exists('bullets', $data)) {
            $data['bullets'] = collect(preg_split('/\r\n|\r|\n/', (string) $data['bullets']))
                ->map(fn ($line) => trim($line))
                ->filter()
                ->values()
                ->all();
        }

        return array_merge($validated, $data);
    }

    private function options(): array
    {
        return [
            'profiles' => PortfolioProfile::orderBy('name')->pluck('name', 'id'),
            'resumeSections' => ResumeSection::orderBy('sort_order')->pluck('name', 'id'),
            'portfolioCategories' => PortfolioCategory::orderBy('sort_order')->pluck('name', 'id'),
        ];
    }
}
