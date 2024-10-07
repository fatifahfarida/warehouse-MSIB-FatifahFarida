<?php
class Gudang
{
    private $conn;
    private $table_name = "gudang";

    public $id;
    public $name;
    public $location;
    public $capacity;
    public $status;
    public $opening_hour;
    public $closing_hour;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new gudang
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, location=:location, capacity=:capacity, status=:status, opening_hour=:opening_hour, closing_hour=:closing_hour";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->opening_hour);
        $stmt->bindParam(":closing_hour", $this->closing_hour);

        return $stmt->execute();
    }

    // Read all gudang with search and pagination
    public function search($search, $limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE name LIKE :search OR location LIKE :search LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);

        $search_param = "%" . $search . "%";
        $stmt->bindParam(':search', $search_param);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    // Count total search results
    public function countSearchResults($search)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE name LIKE :search OR location LIKE :search";
        $stmt = $this->conn->prepare($query);

        $search_param = "%" . $search . "%";
        $stmt->bindParam(':search', $search_param);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Update gudang data
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name, location=:location, capacity=:capacity, status=:status, opening_hour=:opening_hour, closing_hour=:closing_hour WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':capacity', $this->capacity);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':opening_hour', $this->opening_hour);
        $stmt->bindParam(':closing_hour', $this->closing_hour);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete or deactivate a gudang
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Toggle status aktif/non-aktif
    public function toggleStatus()
    {
        $query = "UPDATE " . $this->table_name . " SET status = IF(status = 'aktif', 'tidak_aktif', 'aktif') WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Get data gudang by ID
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
