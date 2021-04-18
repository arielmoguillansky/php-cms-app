var userId;
var userName;
function validateEmail(inputText){
  var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  if(inputText.match(mailformat)){
    return true;
  } else {
    return false;
  }
}
function deleteUser(){
  var deleteAction = `index.php?delete_user_id=${userId}`
  window.location.href = deleteAction; 
}
function showModal(id, name){
  userId = id;
  userName = name;
  document.querySelector('.modal').style.display = "flex";
  document.querySelector('.usersTable').style.filter = "blur(3px)";
  document.querySelector('.modal strong').innerHTML = userName;
}
function rowActive(e){
  e.classList.add("active-row");
}
function rowInactive(e){
  e.classList.remove("active-row");
}
function validatePass(e) {
  if(e.value.length < 6) document.querySelector('.validationPassMsg').style.color = 'red'; 
  else document.querySelector('.validationPassMsg').style.color = 'black';
}
function inputEmailValidation(e) {
  if(!validateEmail(e.value)) document.querySelector('.validationEmailMsg').style.display = 'block';
  else document.querySelector('.validationEmailMsg').style.display = 'none';
}
var cancel = document.querySelector('.cancel');
cancel && cancel.addEventListener('click', function(){
  document.querySelector('.modal').style.display = "none";
  document.querySelector('.usersTable').style.filter = "none";
})
var registrationLink = document.querySelector('.registrationLink');
registrationLink && registrationLink.addEventListener('click', function(){
  document.querySelector('.loginForm').style.display = "none";
  document.querySelector('.registrationForm').style.display = "block";
})
var loginLink = document.querySelector('.loginLink');
loginLink && loginLink.addEventListener('click', function(){
  document.querySelector('.registrationForm').style.display = "none";
  document.querySelector('.loginForm').style.display = "block";
  document.querySelector('.confirmPassMsg').style.display = 'none';
  document.querySelector('.validationPassMsg').style.color = 'black';
  document.querySelector('.validationEmailMsg').style.display = 'none';
})
var rePassInput = document.querySelector('[name="rPassword"]');
rePassInput && rePassInput.addEventListener('blur', function(e){
  if(e.target.value !== passInput.value) document.querySelector('.confirmPassMsg').style.display = 'block'; 
  else document.querySelector('.confirmPassMsg').style.display = 'none';
})