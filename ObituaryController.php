<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObituaryRequest;
use App\Models\Obituary;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ObituaryController extends Controller
{
    /**
     * Task 3: Show the HTML form for submitting a new obituary.
     */
    public function create(): View
    {
        return view('obituaries.create');
    }

    /**
     * Task 4: Backend script for data submission.
     * Captures form data, connects to the DB (via Eloquent), inserts the
     * record, and confirms success — with error handling for DB failures.
     */
    public function store(StoreObituaryRequest $request): RedirectResponse
    {
        try {
            $obituary = Obituary::create($request->validated());
        } catch (\Throwable $e) {
            Log::error('Failed to save obituary: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['database' => 'Something went wrong while saving the obituary. Please try again.']);
        }

        return redirect()
            ->route('obituaries.show', $obituary->slug)
            ->with('success', 'Obituary submitted successfully.');
    }

    /**
     * Task 5: Backend script for data retrieval.
     * Selects all records from the obituaries table, paginated, newest first.
     */
    public function index(): View
    {
        $obituaries = Obituary::orderByDesc('submission_date')->paginate(10);

        return view('obituaries.index', compact('obituaries'));
    }

    /**
     * Task 6: Individual obituary page with SEO / social meta tags,
     * Open Graph tags, and schema.org structured data.
     */
    public function show(Obituary $obituary): View
    {
        return view('obituaries.show', compact('obituary'));
    }
}
