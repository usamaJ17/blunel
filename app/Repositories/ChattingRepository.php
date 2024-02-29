<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChattingRepositoryInterface;
use App\Models\Chatting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ChattingRepository implements ChattingRepositoryInterface
{
    public function __construct(
        private readonly Chatting $chatting
    )
    {
    }
    public function add(array $data): string|object
    {
        return $this->chatting->newInstance()->create($data);
    }

    public function getFirstWhere(array $params, array $relations = []): ?Model
    {
       return $this->chatting->where($params)->first();
    }
    public function getFirstWhereNotNull(array $params,array $filters = [],array $orderBy = [],array $relations = []): ?Model
    {
        return $this->chatting->where($params)->whereNotNull($filters)->orderBy(key($orderBy), current($orderBy))->first();
    }
    public function getListBySelectWhere(array $joinColumn = [], array $select = [],array $filters = [],array $orderBy = []): Collection
    {
        list($table, $first, $operator, $second) = $joinColumn;
        return $this->chatting
            ->join($table, $first, $operator, $second)
            ->select($select)
            ->where($filters)
            ->orderBy(key($orderBy), current($orderBy))
            ->get();
    }

    public function getList(array $orderBy = [], array $relations = [], int|string $dataLimit = DEFAULT_DATA_LIMIT, int $offset = null): Collection|LengthAwarePaginator
    {
        // TODO: Implement getList() method.
    }

    public function getListWhere(array $orderBy = [], string $searchValue = null, array $filters = [], array $relations = [], int|string $dataLimit = DEFAULT_DATA_LIMIT, int $offset = null): Collection|LengthAwarePaginator
    {
        // TODO: Implement getListWhere() method.
    }

    public function updateAllWhere(array $params, array $data) : bool
    {
        return $this->chatting->where($params)->update($data);
    }
    public function update(string $id, array $data): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(array $params): bool
    {
        // TODO: Implement delete() method.
    }
}
