$(".email-signup").hide();
$("#signup-box-link").click(function(){
  $(".email-login").fadeOut(100);
  $(".email-signup").delay(100).fadeIn(100);
  $("#login-box-link").removeClass("active");
  $("#signup-box-link").addClass("active");
});
$("#login-box-link").click(function(){
  $(".email-login").delay(100).fadeIn(100);;
  $(".email-signup").fadeOut(100);
  $("#login-box-link").addClass("active");
  $("#signup-box-link").removeClass("active");
});

// password validation

myInput = function(){
  document.getElementById("message").style.display ="none";
}

var myInput = document.getElementById("password_1");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}



// password and confirm pass validation

$(document).ready(function(){
          
  $("#password_2").bind('keyup change', function(){
    check_Password( $("#password_1").val(), $("#password_2").val() )
  })
  $("#reg_user").click(function(){
    check_Password( $("#password_1").val(), $("#password_2").val() )
  })
})

//FUNCTION to check password between password_1 and password_2
function check_Password(Pass, Con_Pass){
// error messages or success messages
  if(Pass === ""){
  }else if( Pass === Con_Pass){
    $("#reg_user").removeAttr("onclick")
    $('#confirm_password_msg').show()
    $("#confirm_password_msg").html('<div class="alert alert-success">Password matches!</div>')
    setTimeout(function() {
        $('#confirm_password_msg').fadeOut('slow');
    }, 3000);
  }else{
    $("#password_2").focus()
    $('#confirm_password_msg').show()
    $("#confirm_password_msg").html('<div class="alert alert-danger">Password does not match!</div>')
    setTimeout(function() {
        $('#confirm_password_msg').fadeOut('slow');
    }, 3000);

  }

}