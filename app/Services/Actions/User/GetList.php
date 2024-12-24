<?php

declare(strict_types=1);

namespace App\Services\Actions\User;

use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetList
{
    public static function handle()
    {
        $query = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%")
                            ->orWhere('mobile', 'like', "%{$value}%");
                    });
                }),

                AllowedFilter::callback('from_date', function ($query, $value) {
                    $date = verta($value)->datetime();
                    $query->whereDate('created_at', '>=', $date);
                }),
                AllowedFilter::callback('to_date', function ($query, $value) {
                    $date = verta($value)->datetime();
                    $query->whereDate('created_at', '<=', $date);
                }),
            ])
            ->allowedSorts(['name', 'email', 'mobile', 'created_at'])
            ->with('roles:id,name')
            ->latest();

        return $query->paginate(config('pars-ticket.config.per_page'))
            ->withQueryString();
    }
}
