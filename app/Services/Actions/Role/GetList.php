<?php

declare(strict_types=1);

namespace App\Services\Actions\Role;

use App\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class GetList
{
    public static function handle()
    {
        $query = QueryBuilder::for(Role::class)
            ->allowedFilters([
                'name',
                'description',
            ])
            ->allowedSorts([
                'name', 'description', 'created_at'
            ])
            ->defaultSort('name')
            ->latest();

        return $query->paginate(config('pars-ticket.config.paginate.per_page'))
            ->withQueryString();
    }
}
