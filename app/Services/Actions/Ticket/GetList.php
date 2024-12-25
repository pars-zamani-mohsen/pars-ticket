<?php

declare(strict_types=1);

namespace App\Services\Actions\Ticket;

use App\Models\Ticket;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetList
{
    public static function handle()
    {
        $query = QueryBuilder::for(Ticket::class)
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::exact('priority'),
                AllowedFilter::exact('is_resolved'),
                AllowedFilter::exact('category', 'categories.id'),
                AllowedFilter::exact('label', 'labels.id'),
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('title', 'like', "%{$value}%")
                            ->orWhere('message', 'like', "%{$value}%");
                    });
                })
            ])
            ->allowedSorts([
                'created_at',
                'updated_at',
                'priority',
                'status',
                'title'
            ])
            ->with(['user', 'categories', 'labels'])
            ->latest();

        if (! auth()->user()->hasAnyRole('show tickets all')) {
            $query->where('user_id', auth()->id());
        }

        return $query->paginate(config('pars-ticket.config.paginate.per_page'))
            ->withQueryString();
    }
}
