// (*) Validate function
function validateSignin() {
  var signin = document.getElementById("signin");
  var username = signin.querySelector('input[name="username"]');
  var password = signin.querySelector('input[name="password"]');
  if (!username.value) {
    alert("Name cannot be null");
    event.preventDefault();
    return false;
  }
  if (!password.value) {
    event.preventDefault();
    alert("Password cannot be null");
    return false;
  }
  return true;
}
