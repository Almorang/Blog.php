var db = new XMLHttpRequest();
var post = [];
var post_count = 0;
var posts = [];

// fetch the database file
db.open('GET', 'db/db.txt', false);
db.send(null);

// put blog posts into array
posts = db.responseText.split('\n');

// reverse the array to sort by date
posts.reverse();

// remove the empty "post" created by a line with only a newline
posts.splice(0, 1);

post_count = posts.length - 1;
if(post_count >= 0){
    var while_count = post_count;
    do{
        // load post into array
        post = posts[post_count - while_count].split('<');

        // display post
        document.getElementById('blog').innerHTML += '<div class=post>'
            + '<b>' + post[2] + '</b>'
            + ' by <b>' + post[1] + '</b>'
            + ' [' + post[0] + ']<br>'
            + post[3].split('>>').join('<br>')
            + '</div>';
    }while(while_count--);

}else{
    document.getElementById('blog').innerHTML = '<div class=post>'
        + 'There are currently no blog posts to display.'
        + '</div>';
}
