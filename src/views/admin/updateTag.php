<?php
require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Tag.php';

$data = json_decode(file_get_contents('php://input'), true);
$tagId = $data['tagId'];
$newName = $data['newName'];

$tag = new Tag();
$result = $tag->update($tagId, $newName);

if ($result['success']) {
    echo json_encode(['success' => true, 'message' => 'Tag updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => $result['message']]);
}
?>
