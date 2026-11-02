<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ManagementReview;
use Illuminate\Http\Request;

class ManagementReviewController extends Controller
{
    public function index()
    {
        $reviews = ManagementReview::withCount('capas')->latest('meeting_date')->get();

        return view('admin.management-reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.management-reviews.create', ['review' => new ManagementReview(['status' => 'draft'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['created_by'] = auth()->id();
        $review = ManagementReview::create($data);
        ActivityLog::record('create', 'rtm', $review, [], $review->toArray());

        return redirect()->route('admin.management-reviews.index')->with('success', 'RTM berhasil ditambahkan.');
    }

    public function edit(ManagementReview $managementReview)
    {
        return view('admin.management-reviews.edit', ['review' => $managementReview]);
    }

    public function update(Request $request, ManagementReview $managementReview)
    {
        $before = $managementReview->toArray();
        $managementReview->update($this->validatedData($request));
        ActivityLog::record('update', 'rtm', $managementReview, $before, $managementReview->fresh()->toArray());

        return redirect()->route('admin.management-reviews.index')->with('success', 'RTM berhasil diperbarui.');
    }

    public function destroy(ManagementReview $managementReview)
    {
        ActivityLog::record('delete', 'rtm', $managementReview, $managementReview->toArray());
        $managementReview->delete();

        return back()->with('success', 'RTM berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'agenda' => ['nullable', 'string'],
            'participants' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'decisions' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,selesai,ditindaklanjuti'],
        ]);
    }
}
