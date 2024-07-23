<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Crypt;
use Orchid\Platform\Http\Requests\RelationRequest;
use Illuminate\Support\Facades\Schema;

class RelationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function view(RelationRequest $request)
    {
        [
            'model'         => $model,
            'name'          => $name,
            'key'           => $key,
            'scope'         => $scope,
            'append'        => $append,
            'searchColumns' => $searchColumns,
        ] = collect($request->all())
            ->except(['search', 'chunk'])
            ->map(static function ($item, $key) {
                if ($item === null) {
                    return null;
                }

                if ($key === 'scope' || $key === 'searchColumns') {
                    return Crypt::decrypt($item);
                }

                return Crypt::decryptString($item);
            });

        /** @var Model $model */
        /** @psalm-suppress UndefinedClass */
        $model = new $model;
        $search = $request->get('search', '');

        $items = $this->buildersItems($model, $name, $key, $search, $scope, $append, $searchColumns, (int) $request->get('chunk', 10));

        return response()->json($items);
    }

    /**
     * @return mixed
     */
    private function buildersItems(
        Model $model,
        string $name,
        string $key,
        ?string $search = null,
        ?array $scope = [],
        ?string $append = null,
        ?array $searchColumns = null,
        ?int $chunk = 10
    ) {
        if ($scope !== null) {
            /** @var Collection|array $model */
            $model = $model->{$scope['name']}(...$scope['parameters']);
        }

        if (is_array($model)) {
            $model = collect($model);
        }

        if (is_a($model, BaseCollection::class)) {
            return $model->take($chunk)->pluck($append ?? $name, $key);
        }

        $collection = $model->where(function ($query) use ($name, $search, $searchColumns, $model) {
            if (Schema::hasColumn($model->getTable(), $name)){
                $query->where($name, 'like', '%'.$search.'%');
            }
            if ($searchColumns !== null) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%'.$search.'%');
                }
            }
        });

        return $collection
            ->limit($chunk)
            ->get()
            ->mapWithKeys(function ($item) use ($append, $key, $name) {
                $resultKey = $item->$key;

                $value = $item->$append ?? $item->$name;

                if ($resultKey instanceof \UnitEnum) {
                    $resultKey = $resultKey->value;
                }
                if ($value instanceof \UnitEnum) {
                    $value = $value->value;
                }

                return [$resultKey => $value];
            });
    }
}
