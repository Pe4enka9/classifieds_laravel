<?php

namespace App\Http\Queries;

use App\Models\Classified;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClassifiedQuery
{
    /**
     * @param Request $request
     * @return Collection<Classified>
     */
    public function sort(Request $request): Collection
    {
        $query = Classified::query();

        if ($request->get('price') === 'desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('price');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
