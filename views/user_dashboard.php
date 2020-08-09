<html>
<head>
<title><?php echo $title; ?></title>
</head>
<body>
<?php echo $header_content; ?>

<div class="container">
<h3>Update User Info</h3>
<form id="updateForm">
  <div class="form-group">
    <label for="username">Name *</label>
    <input type="text" name="username" id="username" value="<?php echo $user_info['name'];?>" class="form-control" onchange="userValidation()" required>
  </div>
  <!-- <div class="form-group">
    <label for="userpassword">Password *</label>
    <input type="password" name="userpassword" id="userpassword" class="form-control" onchange="userValidation()" required>
  </div> -->
  <div class="form-group">
    <label for="userdob">Date of Birth *</label>
    <input type="text" name="userdob" id="userdob" value="<?php echo $user_info['dob'];?>" class="form-control" placeholder="yyyy-mm-dd" onchange="userValidation()" required>
  </div>
  <button type="submit" class="btn btn-primary" name="btn-update" id="submitUpdate" onsubmit="userValidation()">Update Info</button>
</form>
</div>


<script>
  $(function() {

  $('#submitUpdate').click( function() {
    var user_id = "<?php echo $user_info['id'] ?>";
    // alert(user_id);
    $.ajax({
        url: '/api/user/'+user_id,
        type: 'PUT',
        data: $('form#updateForm').serialize(),
        success: function(data) {
            // alert(data);
        }
    });
});


    $( "#userdob" ).datepicker({ 
      dateFormat: 'yy-mm-dd', 
      changeMonth: true,
      changeYear: true,
      // yearRange: "-100:+0",
      yearRange: '1950:2010'
     });

     //by default disable the submit button
     $('#submit').prop('disabled',true);

  });


  function userValidation(){
      //if all fields are filled then show the submit button
     var name = $('#username').val();
    //  var password = $('#userpassword').val();
     var dob = $('#userdob').val();

      if(name != '' && dob != ''){
        $('#submit').prop('disabled',false);
     }
     else{
        $('#submit').prop('disabled',true);
     }
  }
</script>

</body>
</html>