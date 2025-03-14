<?php
class Event {
    private $conn;
    private $table_name = "events";

    public $id;
    public $name;
    public $description;
    public $date;
    public $image;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all events
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create event
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    name = :name,
                    description = :description,
                    date = :date,
                    image = :image";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->image = htmlspecialchars(strip_tags($this->image));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":image", $this->image);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
