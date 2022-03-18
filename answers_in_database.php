<?php
ini_set('display_errors', 1);
require_once "connect.php";

$answers = $_POST['answers'];
$isCorrect = $_POST['is_correct'];
$youtubeLinkId = $_POST['id'];

$connection = getConnection();

$sql = "SELECT video_id, start, end FROM youtube_links WHERE id = :id";
$query =  $connection->prepare($sql);
$query->execute(['id' => $youtubeLinkId]);
$youtubeLink = $query->fetch();

if(!$youtubeLink) {
    echo "VIDEO_NOT_EXIST";
    exit;
}

$sql = "DELETE FROM answers WHERE youtube_link_id = :id";
$query = $connection->prepare($sql);
$query->execute([
    'id' => $youtubeLinkId
]);

foreach ($answers as $key => $answer) {
    $sql = "INSERT into answers (answer, is_correct, youtube_link_id) VALUES (:answer, :is_correct, :youtube_link_id)";
    $query = $connection->prepare($sql);
    $isCorrectAnswer = $key === (int)$isCorrect ? 1 : 0;
    $query->execute([
        'answer' => $answer,
        'is_correct' => $isCorrectAnswer,
        'youtube_link_id' => $youtubeLinkId,
    ]);

}

header("Location: /index.php");