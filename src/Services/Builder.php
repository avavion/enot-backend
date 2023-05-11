<?php

namespace App\Services;

use PDO;

class Builder
{
    protected array $wheres = [];
    protected array $orders = [];
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function where(string $column, string $operator, string $value, string $boolean = "AND"): Builder
    {
        $this->wheres[] = compact('column', 'operator', 'value', 'boolean');

        return $this;
    }

    public function orderBy(string $column, string $direction = "ASC"): Builder
    {
        $this->orders[] = compact('column', 'direction');

        return $this;
    }

    public function make(array $data): Model
    {
        return $this->getModel()->loadAttributes($data);
    }

    public function update(array $data): Model
    {
        $model = $this->make($data);

        $updatedFields = '';

        foreach ($this->getFillable() as $key) {
            $value = $model->attributes[$key];

            $updatedFields .= "`{$key}` = '{$value}', ";
        }

        $updatedFields = rtrim(trim($updatedFields), ',');

        $query = "UPDATE `{$this->getModel()->getTable()}` SET {$updatedFields} WHERE `id` = :id";

        $statement = Application::$app->database->getPDO()->prepare($query);

        $result = $statement->execute([
            'id' => $data['id']
        ]);

        return $model;
    }

    public function save(): void
    {
        $query = "INSERT INTO {$this->getModel()->getTable()}({$this->getProtectedFieldsQuery()}) VALUES ({$this->getProtectedValuesQuery()})";

        Application::$app->database->getPDO()->exec($query);
    }

    public function create(array $data): Model
    {
        $model = $this->make($data);
        $this->save();
        return $model;
    }

    public function get(array $columns = ['*']): array
    {
        $columnsString = implode(',', $columns);
        $query = $this->assembleQuery($columnsString);

        $statement = Application::$app->database->getPDO()->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function first(array $columns = ['*']): array|null
    {
        $data = $this->get($columns);

        return count($data) ? $data[0] : null;
    }

    private function assembleQuery(string $columns): string
    {
        $whereQuery = '';
        $orderQuery = '';

        if (!empty($this->getWheres())) {
            $whereQuery = "WHERE";
            foreach ($this->getWheres() as $index => $where) {
                $whereQuery .= " {$where['column']} {$where['operator']} '{$where['value']}' ";
                if ($index !== count($this->getWheres()) - 1) $whereQuery .= $where['boolean'];
            }
        }

        if (!empty($this->getOrders())) {
            $ordersForQuery = implode(
                ',',
                array_map(fn ($order) => "{$order['column']} {$order['direction']}", $this->getOrders())
            );

            $orderQuery = "ORDER BY {$ordersForQuery}";
        }

        $query = "SELECT {$columns} FROM {$this->getModel()->getTable()} {$whereQuery} {$orderQuery}";

        return $query;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getWheres()
    {
        return $this->wheres;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getFillable()
    {
        return $this->getModel()->fillable;
    }

    public function getProtectedFieldsQuery()
    {
        return implode(',', $this->getFillable());
    }

    public function getProtectedValuesQuery()
    {
        $callback = fn (string $attr) => "'{$this->getModel()->attributes[$attr]}'";

        return implode(',', array_map($callback, $this->getFillable()));
    }
}
