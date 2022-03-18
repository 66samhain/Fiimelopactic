<?php

require_once "connect.php";

$connection = getConnection();
$youtubeLinks = $connection
    ->query("SELECT id, video_id, start, end FROM youtube_links")
    ->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Songs</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Manage songs</h1>
        <div class="mt-3 mb-3">
            <a href="add_song_page.php" class="btn btn-primary">Add new song</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Video id</th>
                <th scope="col">start</th>
                <th scope="col">end</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($youtubeLinks as $key => $youtubeLink):?>
                <tr>
                    <th scope="row"><?php echo $youtubeLink['id'] ?></th>
                    <td><?php echo $youtubeLink['video_id'] ?></td>
                    <td><?php echo $youtubeLink['start'] ?></td>
                    <td><?php echo $youtubeLink['end'] ?></td>
                    <td>
                        <a href="edit_song_page.php?id=<?php echo $youtubeLink['id'] ?>" type="button" class="btn btn-primary">Edit </a>
                        <form action="delete_song_in_database.php" method="POST" class="pt-2">
                            <input type="hidden" name="id" value="<?php echo $youtubeLink['id'] ?>">
                            <button class="btn btn-primary" type="submit">delete</button>

                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

