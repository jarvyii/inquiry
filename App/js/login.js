
document.getElementById('username').value = 'hello';
var usr = document.getElementById('username');
console.log(usr.value);
$("#singlebutton").click(function(e){
   e.preventDefault();
    console.log(usr.value);  
});
    
