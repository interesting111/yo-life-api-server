<?php

namespace Biz;

abstract class BaseDao
{
    protected $ci;

    public function __construct($ci)
    {
        $this->ci = $ci;
    }

    public abstract function buildQueryStatement($conditions, $statement);

    public function getTable()
    {
        return $this->table;
    }

    public function create($fields)
    {
        $index = array_keys($fields);

        $values = array_values($fields);

        $stmt = $this->getPdo()
                     ->insert($index)
                     ->into($this->getTable())
                     ->values($values);

        $lastInsertId = $stmt->execute(true);

        return $this->get($lastInsertId);
    }

    public function delete($id)
    {
        $stmt = $this->getPdo()
                     ->delete()
                     ->from($this->getTable())
                     ->where('id', '=', $id);

        return $stmt->execute();
    }

    public function get($id)
    {
        $stmt = $this->getPdo()
                     ->select()
                     ->from($this->getTable())
                     ->where('id', '=', $id);

        return $stmt->execute()->fetch();
    }

    public function update($id, $fields)
    {
        $stmt = $this->getPdo()
                     ->update()
                     ->set($fields)
                     ->table($this->getTable())
                     ->where('id', '=', $id);

        $stmt->execute();

        return $this->get($id);
    }

    public function search($conditions, $orderBy, $start, $limit)
    {
        $start = (int) $start;
        $limit = (int) $limit;

        $stmt = $this->getPdo()
                     ->select()
                     ->from($this->getTable());

        if (!empty($conditions)) {
            $stmt = $this->buildQueryStatement($conditions, $stmt);
        }

        $stmt = $stmt->limit($limit, $start);

        foreach ($orderBy as $index => $sort) {
            $stmt = $stmt->orderBy($index, $sort);
        }

        return $stmt->execute()->fetchAll();
    }

    public function count($conditions)
    {
        $stmt = $this->getPdo()
                     ->select(array("COUNT('id') as total"))
                     ->from($this->getTable());

        if (!empty($conditions)) {
            $stmt = $this->buildQueryStatement($conditions, $stmt);
        }

        return $stmt->execute()->fetch()['total'];
    }

    protected function getPdo()
    {
        return $this->ci['db'];
    }
}
