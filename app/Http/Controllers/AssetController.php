<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Magazine;
use App\Models\Certificate;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Public asset listing page.
     * $type can be one of: 3d, image, video, figma, magazine, certificate, all
     *   -> all / null = combined portfolio view
     */
    public function index(Request $request, ?string $type = null)
    {
        $type = $type ?: $request->query('type', 'all');

        $categoryMap = [
            '3d'         => '3D Design',
            'image'      => 'Graphic Design',
            'video'      => 'Animation',
            'figma'      => 'UI/UX Design',
            'web'        => 'Web Development',
        ];

        $projectsQuery = Project::where('status', 'Published')->latest();
        if (array_key_exists($type, $categoryMap)) {
            $projectsQuery->where('category', $categoryMap[$type]);
        }

        // Resolve category for portfolio.blade.php filter tabs.
        $category = $request->query('category', 'All');

        // Apply tab filter to projects (so clicking "3D Design" actually shows 3D-only items).
        $projectCategoryMap = array_flip($categoryMap); // '3D Design' => '3d', ...
        if ($category !== 'All' && isset($projectCategoryMap[$category])) {
            $projectsQuery->where('category', $category);
        }

        $projects = $projectsQuery->get();

        // Magazines and certificates are always available regardless of filter
        $magazines     = Magazine::latest()->get();
        $certificates  = Certificate::latest()->get();

        // Filter magazines by selected category (for tabs under Selected Works)
        $magazineCategory = $request->query('magazine_category', 'All');
        if ($magazineCategory !== 'All') {
            $magazines = $magazines->where('category', $magazineCategory);
        }

        // Stats for filter tabs
        $stats = [
            'all'         => Project::where('status', 'Published')->count() + $magazines->count() + $certificates->count(),
            '3d'          => Project::where('status', 'Published')->where('category', '3D Design')->count(),
            'image'       => Project::where('status', 'Published')->where('category', 'Graphic Design')->count(),
            'video'       => Project::where('status', 'Published')->where('category', 'Animation')->count(),
            'figma'       => Project::where('status', 'Published')->where('category', 'UI/UX Design')->count(),
            'magazine'    => $magazines->count(),
            'certificate' => $certificates->count(),
        ];

        return view('portfolio', compact(
            'projects', 'magazines', 'certificates', 'type', 'stats', 'category', 'magazineCategory'
        ));
    }
}
