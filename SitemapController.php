<?php

namespace App\Http\Controllers;

use App\Models\Obituary;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generates an XML sitemap of every obituary page, for submission
     * to search engines (Task 6.6).
     */
    public function index(): Response
    {
        $obituaries = Obituary::orderByDesc('updated_at')->get();

        $xml = view('sitemap', compact('obituaries'))->render();

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}
