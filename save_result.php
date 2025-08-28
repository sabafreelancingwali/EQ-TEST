<?php
// save_result.php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error'=>'Method not allowed']);
    exit;
}
 
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['error'=>'Invalid JSON']);
    exit;
}
 
$name = isset($data['name']) ? trim($data['name']) : null;
$email = isset($data['email']) ? trim($data['email']) : null;
$score = isset($data['score']) ? (int)$data['score'] : 0;
$max_score = isset($data['max_score']) ? (int)$data['max_score'] : 0;
$answers = isset($data['answers']) ? json_encode($data['answers']) : json_encode([]);
 
require_once 'db.php'; // uses $mysqli
 
$stmt = $mysqli->prepare("INSERT INTO eq_results (name, email, score, max_score, answers) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error'=>'DB prepare failed']);
    exit;
}
$stmt->bind_param('ssiss', $name, $email, $score, $max_score, $answers);
$ok = $stmt->execute();
if (!$ok) {
    http_response_code(500);
    echo json_encode(['error'=>'DB execute failed']);
    exit;
}
$id = $stmt->insert_id;
$stmt->close();
echo json_encode(['success'=>true, 'id'=>$id]);
exit;
?>
