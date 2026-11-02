<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QualityCalendar;
use Illuminate\Http\Request;

class QualityCalendarController extends Controller
{
    public function index()
    {
        $calendars = QualityCalendar::orderBy('start_date')->get();

        return view('admin.quality-calendars.index', compact('calendars'));
    }

    public function create()
    {
        return view('admin.quality-calendars.create', ['calendar' => new QualityCalendar(['category' => 'umum', 'status' => 'terjadwal'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['created_by'] = auth()->id();
        $calendar = QualityCalendar::create($data);
        ActivityLog::record('create', 'kalender-mutu', $calendar, [], $calendar->toArray());

        return redirect()->route('admin.quality-calendars.index')->with('success', 'Agenda mutu berhasil ditambahkan.');
    }

    public function edit(QualityCalendar $qualityCalendar)
    {
        return view('admin.quality-calendars.edit', ['calendar' => $qualityCalendar]);
    }

    public function update(Request $request, QualityCalendar $qualityCalendar)
    {
        $before = $qualityCalendar->toArray();
        $qualityCalendar->update($this->validatedData($request));
        ActivityLog::record('update', 'kalender-mutu', $qualityCalendar, $before, $qualityCalendar->fresh()->toArray());

        return redirect()->route('admin.quality-calendars.index')->with('success', 'Agenda mutu berhasil diperbarui.');
    }

    public function destroy(QualityCalendar $qualityCalendar)
    {
        ActivityLog::record('delete', 'kalender-mutu', $qualityCalendar, $qualityCalendar->toArray());
        $qualityCalendar->delete();

        return back()->with('success', 'Agenda mutu berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:umum,ami,survey,rtm,dokumen,pelaporan'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:terjadwal,berjalan,selesai,batal'],
        ]);
    }
}
