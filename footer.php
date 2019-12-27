</body>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
<script>
$(".dropdown-menu li a").click(function () {
    var selText = $(this).text();
    $(".privacy-value").html(selText);
    $(".getDropdownValue").html(selText);
    console.log(selText);
    
});
</script>

<script>
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' 
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_avatar').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload-avatar.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
        
            $('#uploadimageModal').modal('hide');
            location.reload();
    
        }
      });
    })
  });

});  

</script>


  

<script>
$('#update-avatar').on('click', function() { $('#upload_avatar').click();return false;});
</script>

 <script>
  $('#choose-image').on('click', function() {
    $('#upload_image').click();
    return false;
    });
</script>   

<script>
  $('#upload-image-btn').on('click', function() { 
    $('#upload-image').click();
    return false;
    });
</script>  

<script>
$(document).ready(function(){
$('#about-btn').on('click', function() {
    console.log('click');
     $('#all-post').hide();
     $('#friends-of-user').hide();
    $('#about-user').show();
    return false;
});

$('#timeline-btn').on('click', function() {
    console.log('click');
    $('#about-user').hide();
    $('#friends-of-user').hide();
    $('#all-post').show();
    return false;
});

$('#friendlist-btn').on('click', function() {
    console.log('click');
    $('#all-post').hide();
    $('#about-user').hide();
    $('#friends-of-user').show();
    return false;
});
});
</script>


</html>