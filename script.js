$(function() {
  console.log("leht on laetud");

  getTweets();

});

var getTweets = function(){
  console.log("gettin tweets ...");

  $.ajax({
    url: "getFeed.php",
    success: function(result){
      //console.log(JSON.parse(result).api.statuses);

      printTweets(JSON.parse(result).api.statuses);
    },
    error: function(xhr, status, error){
      console.log(error);
    }
    });
};

var printTweets = function(ajaxStatuses){

  //foreach
  $.each(ajaxStatuses, function(index, tweet){
      /*
        <div class="item">
          <img class="profile-img" src="" alt="">
          <div class="author"></div>
          <p class="text"></p>
        </div>
      */
      var item =  '<div class="item">'+
                  '<img class="profile-img" src="'+tweet.user.profile_image_url.replace("_normal","")+'" alt="">'+
                  '<div class="author">'+tweet.user.name+'</div>'+
                  '<p class="text">'+tweet.text+'</p>'+
                  '</div>';
      console.log($(item));
  });

};
