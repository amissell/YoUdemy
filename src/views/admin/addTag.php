<?php
require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Tag.php';

$data = json_decode(file_get_contents('php://input'), true);
$tagName = $data['tagName'];

$tag = new Tag($tagName);
$result = $tag->create();

if ($result['success']) {
    echo json_encode(['success' => true, 'message' => 'Tag added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => $result['message']]);
}
?>
