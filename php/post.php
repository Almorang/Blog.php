<?php ?>
<?php if(isset($_POST['post-button'])){
    // Load settings.
    require 'settings.php';

    // Verify password.
    if($_POST['password'] != $secret_password){
        header('Location:../?incorrect_password');
        exit;
    }

    // Create an array with new post information.
    $post = array(
      "content" => htmlspecialchars(trim($_POST['content'])),
      "date" => date('Y-m-d H:i:s'),
      "title" => htmlspecialchars(trim($_POST['title'])),
      "username" => htmlspecialchars(trim($_POST['username'])),
    );
    $post_id = htmlspecialchars(trim($_POST['id']));

    // Add the new $post to the existing posts
    //   and sort the posts by date.
    $posts = json_decode(file_get_contents($database_path), true);
    $posts[$post_id] = $post;
    uasort($posts, function($a, $b){
        return strtotime($b['date']) - strtotime($a['date']);
    });
    $posts = json_encode($posts, JSON_FORCE_OBJECT);

    // Update the database file.
    file_put_contents(
      $database_path,
      $posts
    );
}

// Return to the blog index.
header('Location:..');
