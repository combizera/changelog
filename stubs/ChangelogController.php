<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Changelog;

class ChangelogController extends Controller
{
    public function index(Request $request)
    {
        $query = Changelog::published()->orderBy('release_date', 'desc');

        // Filter by type if provided
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        $changelogs = $query->get();
        $types = ['new', 'improvement', 'fix', 'security', 'deprecated'];

        return view('changelog', compact('changelogs', 'types'));
    }
}
