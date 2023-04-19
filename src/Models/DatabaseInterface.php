<?php

namespace Toanlt\Crawler\Models;

interface DatabaseInterface
{
    /**
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    public function insert(string $table, array $data): bool|string;

    /**
     * @param string $table
     * @param array $data
     * @param string|null $where
     * @return int
     */
    public function update(string $table, array $data, string $where = null): int;

    /**
     * @param string $table
     * @param string $where
     * @return int
     */
    public function delete(string $table, string $where): int;

    /**
     * @param string $table
     * @param string $where
     * @return int
     */
    public function get(string $table, string $where = null): bool|array;
}