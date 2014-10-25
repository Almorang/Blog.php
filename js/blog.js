;(function(){
    // Fetch the database file.
    var db = new XMLHttpRequest();
    db.open(
      'GET',
      'db/db.txt',
      false
    );
    db.send(null);

    // Put blog posts into an array.
    var posts = [];
    posts = db.responseText.split('\n');

    // Reverse the array to sort by date.
    posts.reverse();

    // Remove the empty "post" created by a line with only a newline.
    posts.splice(
      0,
      1
    );

    var post_count = posts.length - 1;

    // No posts? We're done here.
    if(post_count < 0){
        document.getElementById('blog').innerHTML = '<div class=blog-post>'
          + 'There are currently no blog posts to display.'
          + '</div>';
        return;
    }

    var post = [];

    var loop_counter = post_count;
    do{
        // Load post into array.
        post = posts[post_count - loop_counter].split('<');

        // Display post.
        document.getElementById('blog').innerHTML += '<div class=blog-post>'
          + '<b>' + post[2] + '</b>'
          + ' by <b>' + post[1] + '</b>'
          + ' [' + post[0] + ']<br>'
          + post[3].split('>>').join('<br>')
          + '</div>';
    }while(loop_counter--);
}());
