<?php
class EventController {
    private $db;
    private $event;

    public function __construct($db) {
        $this->db = $db;
        $this->event = new Event($db);
    }

    // Get all events
    public function getEvents() {
        $stmt = $this->event->getAll();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($events);
    }

    // Create new event
    public function createEvent() {
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        
        if(
            !empty($data->name) &&
            !empty($data->description) &&
            !empty($data->date)
        ) {
            $this->event->name = $data->name;
            $this->event->description = $data->description;
            $this->event->date = $data->date;
            $this->event->image = $data->image ?? '';

            if($this->event->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Event created successfully."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create event."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create event. Data is incomplete."));
        }
    }
}
?>
