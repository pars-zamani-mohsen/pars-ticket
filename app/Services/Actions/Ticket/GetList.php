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
            ->defaultSort('-updated_at');

        if (! auth()->user()->can('show tickets all')) {
            if (auth()->user()->can('show tickets all-in-category')) {
                $query->whereHas('categories', function($q) {
                    $q->whereIn('categories.id', auth()->user()->categories->pluck('id'));
                });
            } else {
                $query->where('user_id', auth()->id());
            }
        }

        return $query->paginate(config('pars-ticket.config.per_page'))
            ->withQueryString();
    }
}
