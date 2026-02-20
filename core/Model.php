<?php
/**
 * Model — TSILIZY Nexus
 *
 * Base ORM using PDO prepared statements exclusively.
 * Provides CRUD, search, pagination, soft deletes, and raw query support.
 * Every child model must define $table and $fillable.
 */

class Model
{
    /** Table name — override in child */
    protected string $table = '';

    /** Whether to use soft deletes */
    protected bool $softDelete = false;

    /** Fillable columns — override in child */
    protected array $fillable = [];

    // -----------------------------------------------------------------
    // Database access
    // -----------------------------------------------------------------

    /**
     * Get PDO instance
     */
    public function db(): PDO
    {
        return Database::getInstance();
    }

    // -----------------------------------------------------------------
    // READ operations
    // -----------------------------------------------------------------

    /**
     * Find a single record by ID
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `id` = :id";
        if ($this->softDelete) {
            $sql .= " AND `deleted_at` IS NULL";
        }
        $sql .= " LIMIT 1";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Find first record matching conditions
     */
    public function findWhere(array $conditions): ?array
    {
        [$where, $params] = $this->buildWhere($conditions);
        $sql = "SELECT * FROM `{$this->table}` WHERE {$where}";
        if ($this->softDelete) {
            $sql .= " AND `deleted_at` IS NULL";
        }
        $sql .= " LIMIT 1";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Get all records matching conditions
     */
    public function where(array $conditions = [], string $orderBy = 'id', string $direction = 'DESC'): array
    {
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        $orderBy = preg_replace('/[^a-zA-Z0-9_]/', '', $orderBy);

        if (empty($conditions)) {
            $sql = "SELECT * FROM `{$this->table}`";
            $params = [];
        } else {
            [$where, $params] = $this->buildWhere($conditions);
            $sql = "SELECT * FROM `{$this->table}` WHERE {$where}";
        }

        if ($this->softDelete) {
            $sql .= (empty($conditions) ? ' WHERE' : ' AND') . " `deleted_at` IS NULL";
        }

        $sql .= " ORDER BY `{$orderBy}` {$direction}";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get all records (alias)
     */
    public function all(string $orderBy = 'id', string $direction = 'DESC'): array
    {
        return $this->where([], $orderBy, $direction);
    }

    // -----------------------------------------------------------------
    // COUNT
    // -----------------------------------------------------------------

    /**
     * Count records matching conditions
     */
    public function count(array $conditions = []): int
    {
        if (empty($conditions)) {
            $sql = "SELECT COUNT(*) as c FROM `{$this->table}`";
            $params = [];
        } else {
            [$where, $params] = $this->buildWhere($conditions);
            $sql = "SELECT COUNT(*) as c FROM `{$this->table}` WHERE {$where}";
        }

        if ($this->softDelete) {
            $sql .= (empty($conditions) ? ' WHERE' : ' AND') . " `deleted_at` IS NULL";
        }

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    // -----------------------------------------------------------------
    // PAGINATION
    // -----------------------------------------------------------------

    /**
     * Paginate results
     */
    public function paginate(int $page = 1, int $perPage = 20, array $conditions = [], string $orderBy = 'id', string $direction = 'DESC'): array
    {
        $page    = max(1, $page);
        $offset  = ($page - 1) * $perPage;
        $total   = $this->count($conditions);
        $pages   = (int) ceil($total / $perPage);

        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        $orderBy   = preg_replace('/[^a-zA-Z0-9_]/', '', $orderBy);

        if (empty($conditions)) {
            $sql = "SELECT * FROM `{$this->table}`";
            $params = [];
        } else {
            [$where, $params] = $this->buildWhere($conditions);
            $sql = "SELECT * FROM `{$this->table}` WHERE {$where}";
        }

        if ($this->softDelete) {
            $sql .= (empty($conditions) ? ' WHERE' : ' AND') . " `deleted_at` IS NULL";
        }

        $sql .= " ORDER BY `{$orderBy}` {$direction} LIMIT {$perPage} OFFSET {$offset}";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);

        return [
            'data'         => $stmt->fetchAll(),
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'last_page'    => $pages,
            'from'         => $total > 0 ? $offset + 1 : 0,
            'to'           => min($offset + $perPage, $total),
        ];
    }

    // -----------------------------------------------------------------
    // SEARCH
    // -----------------------------------------------------------------

    /**
     * Search across specified columns with LIKE
     */
    public function search(string $query, array $columns): array
    {
        if (empty($columns) || empty($query)) return [];

        $clauses = [];
        $params  = [];
        foreach ($columns as $i => $col) {
            $col = preg_replace('/[^a-zA-Z0-9_]/', '', $col);
            $key = "q{$i}";
            $clauses[] = "`{$col}` LIKE :{$key}";
            $params[$key] = "%{$query}%";
        }

        $sql = "SELECT * FROM `{$this->table}` WHERE (" . implode(' OR ', $clauses) . ")";
        if ($this->softDelete) {
            $sql .= " AND `deleted_at` IS NULL";
        }
        $sql .= " LIMIT 50";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // -----------------------------------------------------------------
    // CREATE
    // -----------------------------------------------------------------

    /**
     * Insert a new record, return new ID
     */
    public function create(array $data): int
    {
        $data = $this->filterFillable($data);
        if (empty($data)) return 0;

        $columns = implode('`, `', array_keys($data));
        $placeh  = implode(', ', array_map(fn($k) => ":{$k}", array_keys($data)));

        $sql = "INSERT INTO `{$this->table}` (`{$columns}`) VALUES ({$placeh})";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db()->lastInsertId();
    }

    // -----------------------------------------------------------------
    // UPDATE
    // -----------------------------------------------------------------

    /**
     * Update a record by ID
     */
    public function update(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        if (empty($data)) return false;

        $sets = [];
        foreach (array_keys($data) as $col) {
            $sets[] = "`{$col}` = :{$col}";
        }
        $data['_id'] = $id;

        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $sets) . " WHERE `id` = :_id";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($data);
    }

    // -----------------------------------------------------------------
    // DELETE
    // -----------------------------------------------------------------

    /**
     * Delete (soft or hard) a record by ID
     */
    public function delete(int $id): bool
    {
        if ($this->softDelete) {
            return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        }

        $stmt = $this->db()->prepare("DELETE FROM `{$this->table}` WHERE `id` = :id");
        return $stmt->execute(['id' => $id]);
    }

    // -----------------------------------------------------------------
    // RAW QUERIES (always prepared statements)
    // -----------------------------------------------------------------

    /**
     * Execute raw SELECT and return result set
     */
    public function raw(string $sql, array $params = []): array
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute raw non-SELECT query (INSERT, UPDATE, DELETE)
     */
    public function rawExecute(string $sql, array $params = []): bool
    {
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($params);
    }

    // -----------------------------------------------------------------
    // Internal helpers
    // -----------------------------------------------------------------

    /**
     * Build WHERE clause from associative array
     * Returns [sql_string, params_array]
     */
    private function buildWhere(array $conditions): array
    {
        $clauses = [];
        $params  = [];
        foreach ($conditions as $col => $val) {
            $safe = preg_replace('/[^a-zA-Z0-9_]/', '', $col);
            $key  = "w_{$safe}";

            if ($val === null) {
                $clauses[] = "`{$safe}` IS NULL";
            } else {
                $clauses[] = "`{$safe}` = :{$key}";
                $params[$key] = $val;
            }
        }
        return [implode(' AND ', $clauses), $params];
    }

    /**
     * Filter data to only fillable columns
     */
    private function filterFillable(array $data): array
    {
        if (empty($this->fillable)) return $data;
        return array_intersect_key($data, array_flip($this->fillable));
    }
}
