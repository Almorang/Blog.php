<?php ?>
<?php if(isset($_POST['post-button'])){

    $secret_username = 'admin';
    $secret_password = 'admin_password';

    $maxlength_content = 500;
    $maxlength_title   = 50;

    // verify username and password
    if( $_POST['username'] == $secret_username
     && $_POST['password'] == $secret_password){

        // verify length of post title
        $length = strlen(trim($_POST['title']));
        if($length > 0 && $length <= $maxlength_title){

            // verify length of post content
            $length = strlen(trim($_POST['content']));
            if($length > 0 && $length <= $maxlength_content){

                // load the database file
                $db = fopen('../db/db.txt', 'a+');

                // lock the database file
                if(flock($db, LOCK_EX)){

                    // write blog post at the end of the database file
                    fwrite(
                        $db,
                        date('Y-m-d H:i:s')
                      . '<'
                      . $secret_username
                      . '<'
                      . htmlspecialchars(trim($_POST['title']))
                      . '<'
                      . str_replace(array("\r\n", "\n", "\r"), '>>', htmlspecialchars(trim($_POST['content'])))
                      . '<'
                      . "0\n"
                    );

                    // unlock the database file
                    flock($db, LOCK_UN);

                    // close the database file
                    fclose($db);
                }
            }
        }
    }
}

// return to the blog index
header('Location:..');

?>
