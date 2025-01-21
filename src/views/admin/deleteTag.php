<?php
require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Tag.php';

$data = json_decode(file_get_contents('php://input'), true);
$tagId = $data['tagId'];

$tag = new Tag();
$result = $tag->delete($tagId);

if ($result['success']) {
    echo json_encode(['success' => true, 'message' => 'Tag deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => $result['message']]);
}
?>
