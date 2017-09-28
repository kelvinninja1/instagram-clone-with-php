/*global $*/

function onload(){
    //start a promise chain
    Promise.resolve()
    .then(function(){
        return $.post('feed.php?query=post');  
    })
    //when the server responds, we'll execute this code
    .then(function(posts){
        //jQuery function to set the innerHTML of the div with id = 'posts' to empty
       // $('#feed-container').empty();
        //loop over each post item in the posts array
        posts.forEach(function(post){
            Promise.resolve()
            .then(function(posts){
        
              var feedBlockTemplate = "";
              var likesText = (post.likeCount > 1)? "likes": "like";
              
              
              $('#feed-container').prepend(
                '<div class="feed-block" data-postId="' + post.postID + '">' +
                '  <div class="feed-header">' +
                '<a href="" class="feed-avatar">' +
                '      <img src="'+ post.profilePicture +'" class="feed-avatar-image small"></img>' +
                '    </a>' +
                '    <div class="feed-info">' +
                '      <a class="feed-user" href="">' + post.userName + '</a></div>'+
                '    <a href="" class="feed-time">' +
                '      <time>' + post.datePosted + '</time>' +
                '    </a>' +
                '  </div>' +
                '  <a href="" class="feed-image">' +
                '    <img src="'+ post.imageURL +'" class="img-responsive" alt="">' +
                '  </a>' +
                '  <div class="feed-body">' +
                '    <p class="likes"><span id ="like' + post.postID + '">'+ post.likeCount +'</span> '+ likesText +'</p>' +
                '    <ul class="comment-list">' +
                '      <li>' +
                '        <a class="feed-user" href="">' +
                           post.userName +
                '        </a>' + post.caption +'</li></ul>' +
                '    <div class="add-comment">' +
                '      <a class="fa fa-heart-o like-photo" onclick="likeClick(\'' + post.postID + '\');"></a>' +
                '      <form class="add-comment-form">' +
                '        <input type="text" placeholder="Add a comment..." class="add-comment-input" name=""/>' +
                '      </form>' +
                '    </div>' +
                '  </div>' +
                '</div>' 
              );
              var currentPost = post.postID;
              Promise.resolve(currentPost)
              .then(function(currentPost){
                console.log(currentPost);
                return $.post('feed.php?query=comment&postToSearch='+currentPost);
              })
              .then(function(comments){
                comments.forEach(function(entry){
                   console.log(post.postID); 
                   $("[data-postid='" + post.postID + "']").find(".comment-list").append(
                    '      <li>' +
                    '        <a class="feed-user" href="">' + entry.userC + '</a>'+
                             entry.content + '</li></ul>'
                   );
                });
              })
              .then(function(){
                  return $.post('feed.php?query=hashtag&postToSearch='+post.postID);
              })
              .then(function(hashtags){
                $("[data-postid='" + post.postID + "']").find(".comment-list li:first-child").append(
                  '      <li class="comment-hashtags">' +
                  '        <a class="feed-user" href="">' + $(".feed-block:last-child .comment-list li:first-child .feed-user").text() + '</a>'+
                  '</li></ul>'
                 );
                hashtags.forEach(function(hashtag){
                  console.log(hashtag); 
                  $(".feed-block:last-child .comment-hashtags").append(
                    '<a class="hashtag">#' +hashtag.tag  + '</a>'
                  ); 
                });
              })
              .catch(function(err){
                //always include a catch for exceptions
                console.log(err);
              });
              
            })
            .catch(function(err){
              //always include a catch for exceptions
              console.log(err);
            });
        });
    })
    .catch(function(err){
        //always include a catch for exceptions
        console.log(err);
    });
}

function likeClick(id){
    event.preventDefault();

    Promise.resolve()
    .then(function(){
        //jQuery provides a nice convenience method for easily sending a post with parameters in JSON
        //here we pass the ID to the incrLike route on the server side so it can do the incrementing for us
        //note the return. This MUST be here, or the subsequent then will not wait for this to complete
        return $.post('like.php?postID='+id);
    })
    .then(function(like){
        //jQuery provides a nice convenience methot for easily setting the count to the value returned
       if (typeof like === 'string' || like instanceof String)
        $('body').prepend(like);
        else{ 
            console.log(like);
            if(like[0].likeCount > 1) {
               var currentText =  $("[data-postid='" + like[0].postID + "']").find(".likes").html();
               $("[data-postid='" + like[0].postID + "']").find(".likes").html( currentText.replace(/like$/,"likes"));
            }
         document.getElementById('like' + like[0].postID).innerHTML = like[0].likeCount
       } 
       
       
    })
    .catch(function(err){
        //always include a catch for the promise chain
        console.log(err);
    });
}
