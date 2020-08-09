<html>
<head>
<title><?php echo $title; ?></title>
</head>
<body>
<?php echo $header_content; ?>

<div class="container">
<h3>Log in Form</h3>
<form method="POST" action="login">
  <div class="form-group">
    <label for="useremail">Email address *</label>
    <input type="email" name="useremail" id="useremail" class="form-control" aria-describedby="emailHelp" onblur="confirmUserEmail(this.value);validateEmail(this.value);" onchange="userValidation()" required>
    <small id="useremailmessage"></small>
  </div>
  <div class="form-group">
    <label for="userpassword">Password *</label>
    <input type="password" name="userpassword" id="userpassword" class="form-control" onchange="userValidation()" required>
  </div>
  <button type="submit" class="btn btn-primary" name="btn-login" id="submit" onsubmit="userValidation()">Log In</button>
</form>
</div>


<script>
  $(function() {
     //by default disable the submit button
     $('#submit').prop('disabled',true);

  });


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
     var email = $('#useremail').val();
     var password = $('#userpassword').val();

      if(email != '' && password != ''){
        $('#submit').prop('disabled',false);
     }
     else{
        $('#submit').prop('disabled',true);
        return false;
     }
  }

  
</script>

</body>
</html>