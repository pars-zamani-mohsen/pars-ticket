<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = QueryBuilder::for(Activity::class)
            ->allowedFilters([
                AllowedFilter::exact('causer_type'),
                AllowedFilter::exact('causer_id'),
                AllowedFilter::exact('subject_type'),
                AllowedFilter::exact('subject_id'),
                AllowedFilter::exact('event'),
                AllowedFilter::scope('created_at_between'),
                'description',
                'properties',
            ])
            ->allowedSorts(['created_at', 'event', 'subject_type'])
            ->with(['causer', 'subject'])
            ->latest()
            ->paginate(config('pars-ticket.config.per_page'));

        return view('admin.activity-logs.index', compact('activities'));
    }
}
