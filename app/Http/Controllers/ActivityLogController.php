<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query()->orderBy('created_at', 'desc');

        if ($request->filled('user_name')) {
            $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(30)->withQueryString();

        $userNames  = ActivityLog::select('user_name')->distinct()->pluck('user_name');
        $modelTypes = ActivityLog::whereNotNull('model_type')->select('model_type')->distinct()->pluck('model_type');

        return view('inventori.activity-log', compact('logs', 'userNames', 'modelTypes'));
    }
}