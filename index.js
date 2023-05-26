$('#postdata').keydown(function(e){
  if(e.which == 13){
    e.preventDefault();
    return false;
  }
});

jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#postdata" ).validate( {
  // This global normalizer will trim the value of all elements
  // before validatng them.
  normalizer: function( value ) {
    return $.trim( value );
  },
  rules: {
    title: {
      required: true
    },
    desc: {
      required: true
    },
    url: {
      required: true,
      url: true,
  
      normalizer: function( value ) {
        var url = value;
  
        if ( url && url.substr( 0, 7 ) !== "http://"
            && url.substr( 0, 8 ) !== "https://"
            && url.substr( 0, 6 ) !== "ftp://" ) {
          url = "http://" + url;
        }
        return url;
      }
    }
  }
} );  


$("#postdata").on("submit", function (e) {
  e.preventDefault();
  console.log("submitted");
  
  if($("#postdata").valid()){
    $.ajax({
      method: "POST",
      url: "post.php",
      data: new FormData(this),
      processData: false,
      cache: false,
      contentType: false,
      success: function (data) {
       console.log(data);
        $(".container-article, .container-post, .container-text").css("height", "368px");
        $(".container-article, .container-post, .container-text").html(
          `<a href="createarticle.php">Article</a>
          <a href="createpost.php">Post</a>
          <a href="createpost.php">Text</a><a href="logout.php">Logout</a><br><br>
          <img width="200px" src="LinkedIn.png"><div class="brand-title">LinkedIn</div>
          <h3>Post created successfully!!!</h3>`
        );
        $(".brand-logo").css("display", "none");
        swal("Good job!", "Your post is posted successfully", "success");  
      },
      error: function (data) {
        $("#target").html(data);
      },
    });
  } else {
        $(".container-article, .container-post").css("height", "844px");
  }
});


$("#input-tags").keydown(function(e){
  if(e.which == 13 && e.target.value!=''){
    $('.container-article').css('height','850px');
    $('.container-post').css('height','780px');
    $('#tags').append(`<div class="chip">
      ${e.target.value}
      <span class="closebtn" onclick="this.parentElement.remove()">&times;</span>
    </div> `);
    let tag_val = $("input[name='tags']").val();
    $("input[name='tags']").val(tag_val + ' #' + e.target.value);
    console.log($("input[name='tags']").val());
    e.target.value='';
  }
});