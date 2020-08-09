<html>
<head>
<title><?php echo $title; ?></title>
</head>
<body>
<?php echo $header_content; ?>

<div class="container">
<h3>Sign Up Form</h3>
<form method="POST" action="signup">
  <div class="form-group">
    <label for="username">Name *</label>
    <input type="text" name="username" id="username" class="form-control" onchange="userValidation()" required>
  </div>
  <div class="form-group">
    <label for="useremail">Email address *</label>
    <input type="email" name="useremail" id="useremail" class="form-control" aria-describedby="emailHelp" onblur="confirmUserEmail(this.value);validateEmail(this.value);" onchange="userValidation()" required>
    <small id="useremailmessage"></small>
  </div>
  <div class="form-group">
    <label for="userpassword">Password *</label>
    <input type="password" name="userpassword" id="userpassword" class="form-control" onchange="userValidation()" required>
  </div>
  <div class="form-group">
    <label for="userdob">Date of Birth *</label>
    <input type="text" name="userdob" id="userdob" class="form-control" placeholder="yyyy-mm-dd" onchange="userValidation()" required>
  </div>
  <button type="submit" class="btn btn-primary" name="btn-signup" id="submit" onsubmit="userValidation()">Sign Up</button>
</form>
</div>


<script>
  $(function() {
    // window.location.href = "login";
  //   $("#submit").submit(function(){
  //     window.location.href = "login";
  //     // setTimeout(function(){ 
  //     //   // alert("test"); 
        
  //     // }, 300);
  // });


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

  function confirmUserEmail(val) {
        //alert('working');
        $.ajax({
        type: "POST",
        url: "../ajax_call/confirm_email_availability.php",
        data:'useremail='+val,
        success: function(data){
          $("#useremailmessage").html(data);
        }
    });
  }

  function validateEmail(emailid){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var email = $('#useremail').val();

        if(email != ''){
          if (!reg.test(emailid)) {
                alert('Invalid Email Address');
                // $("#useremail").focus();
                return false;
          }
          return true;
        }
  }

  function userValidation(){
      //if all fields are filled then show the submit button
     var name = $('#username').val();
     var email = $('#useremail').val();
     var password = $('#userpassword').val();
     var dob = $('#userdob').val();

      if(name != '' && email != '' && password != '' && dob != ''){
        $('#submit').prop('disabled',false);
     }
     else{
        $('#submit').prop('disabled',true);
     }
  }
</script>

</body>
</html>