<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>

<script type="text/javascript">
    $(function() {
$(".submit").click(function() {
var name = $("#name").val();
var username = $("#username").val();
var password = $("#password").val();
var gender = $("#gender").val();
var dataString = 'name='+ name + '&username=' + username + '&password=' + password + '&gender=' + gender;

if(name=='' || username=='' || password=='' || gender=='')
{
$('.success').fadeOut(200).hide();
$('.error').fadeOut(200).show();
}
else
{
$.ajax({
type: "POST",
url: "testAsync.php",
data: dataString,
success: function(){
$('.success').fadeIn(200).show();
$('.error').fadeOut(200).hide();
}
});
}
return false;
});
});
    </script>
    
    <form method="post" name="form">
<ul><li>
<input id="name" name="name" type="text" />
</li><li>
<input id="username" name="username" type="text" />
</li><li>
<input id="password" name="password" type="password" />
</li><li>
<select id="gender" name="gender">
<option value="">Gender</option>
<option value="1">Male</option>
<option value="2">Female</option>
</select>
</li></ul>
<div >
<input type="submit" value="Submit" class="submit"/>
<span class="error" style="display:none"> Please Enter Valid Data</span>
<span class="success" style="display:none"> Registration Successfully</span>
</div></form&gt;
<?php include 'configuration/footer.php'; ?>

<script type="text/javascript">
    $(function(){
        $("#add_patient").click(function(){
            
            
            if($("#pass1").val().length < 8){
                alert("Password Cannot be less than 8 characters, Please try again");
               $("#pass1").focus();
                return false;
            }
        });
    });
</script>
