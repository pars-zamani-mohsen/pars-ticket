<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Morilog\Jalali\Jalalian;
use Spatie\Activitylog\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityLogController extends Controller
{
    public function index()
    {
        $this->authorizeRoleOrPermission('show logs');

        $activities = QueryBuilder::for(Activity::class)
            ->allowedFilters([
                AllowedFilter::exact('causer_type'),
                AllowedFilter::callback('causer_name', function ($query, $value) {
                    return $query->whereHasMorph('causer', [User::class], function ($q) use ($value) {
                        $q->where('name', 'LIKE', "%{$value}%");
                    });
                }),
                AllowedFilter::exact('subject_type'),
                AllowedFilter::exact('subject_id'),
                AllowedFilter::exact('event'),
                AllowedFilter::callback('from_date', function ($query, $value) {
                    $date = Jalalian::fromFormat('Y/m/d', $value)->toCarbon();
                    $query->whereDate('created_at', '>=', $date->startOfDay());
                }),
                AllowedFilter::callback('to_date', function ($query, $value) {
                    $date = Jalalian::fromFormat('Y/m/d', $value)->toCarbon();
                    $query->whereDate('created_at', '<=', $date->endOfDay());
                }),
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
