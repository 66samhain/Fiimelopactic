<?php
ini_set('display_errors', 1);

$id = $_GET['id'];
require_once "connect.php";

$connection = getConnection();

$sql = "SELECT answer, is_correct,youtube_link_id FROM answers WHERE youtube_link_id = :youtube_link_id";
$query = $connection->prepare($sql);
$query->execute(['youtube_link_id' => $id]);
$answers = $query->fetchAll();

if (!count($answers)) {
    for ($i = 0; $i < 3; $i++) {
        $answers[] = [
            'text' => null,
            'is_correct' => false
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="">
<head>
    <title>Add song</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Answers</h1>
    <form method="post" action="answers_in_database.php">
        <div class="mb-3">
            <label for="is_correct" class="form-label">Is correct</label>
            <select class="form-select" name="is_correct" id="is_correct">
                <?php foreach ($answers as $key => $answer): ?>
                    <option
                        <?php if ($answer['is_correct']): ?> selected <?php endif; ?>
                            value="<?php echo $key + 1 ?>">Answer <?php echo $key + 1 ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>
        <?php foreach ($answers as $key => $answer): ?>
            <div class="mb-3">
                <label for="answer<?php echo $key ?>" class="form-label">Answer <?php echo $key + 1 ?></label>
                <input required type="text" name="answers[<?php echo $key + 1 ?>]" value="<?php echo $answer['answer'] ?>"
                       class="form-control" id="answer<?php echo $key ?>">
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
