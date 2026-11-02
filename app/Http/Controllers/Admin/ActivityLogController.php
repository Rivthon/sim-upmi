<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->filled('module'), fn ($query) => $query->where('module', $request->module))
            ->when($request->filled('action'), fn ($query) => $query->where('action', $request->action))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $modules = ActivityLog::query()->whereNotNull('module')->distinct()->orderBy('module')->pluck('module');
        $actions = ActivityLog::query()->distinct()->orderBy('action')->pluck('action');

        return view('admin.activity-log.index', compact('logs', 'modules', 'actions'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');

        return view('admin.activity-log.show', compact('activityLog'));
    }
}
