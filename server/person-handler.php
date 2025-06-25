
<?php
require_once "Person.php";
$person = new Person();

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $person->create($_POST['name'], $_POST['age'], $_POST['gender']) ? "success" : "error";
        }
        break;

    case 'read':
        echo json_encode($person->read());
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $person->update($_POST['id'], $_POST['name'], $_POST['age'], $_POST['gender']) ? "updated" : "error";
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $person->delete($_POST['id']) ? "deleted" : "error";
        }
        break;

    case 'search':
        echo json_encode($person->search($_GET['q'] ?? ''));
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}
