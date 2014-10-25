<?php ?>
<?php if(isset($_POST['post-button'])){

    // Load settings.
    require 'settings.php';

    // Verify password.
    if($_POST['password'] != $secret_password){
        header('Location:../?incorrect_password');
        exit;
    }

    // Load the database file.
    $db = fopen(
      $database_path,
      'a+'
    );

    // lock the database file
    if(flock($db, LOCK_EX)){

        // Write blog post at the end of the database file.
        fwrite(
          $db,
          date('Y-m-d H:i:s')
          . '<'
          . htmlspecialchars(trim($_POST['username']))
          . '<'
          . htmlspecialchars(trim($_POST['title']))
          . '<'
          . str_replace(
            array(
              "\r\n",
              "\n",
              "\r"
            ),
            '>>',
            htmlspecialchars(trim($_POST['content']))
          )
          . "\n"
        );

        // Unlock the database file.
        flock(
          $db,
          LOCK_UN
        );

        // Close the database file.
        fclose($db);
    }
}

// Return to the blog index.
header('Location:..');
