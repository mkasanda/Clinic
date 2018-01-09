/* Java Script */
/* By Malama Kasanda */

function genID()
{
	try {
	var studid = '';
	var smDate = new Date();
	var yr = (''+smDate.getYear()+1900).substring(2,4);
	var mnth = '0'+(smDate.getMonth()+1);
	while(studid.length <= 4)
	{
		studid += ''+Math.floor(Math.random() * (9+1));
	}
	return yr+mnth+studid;
	} catch(e) {
		alert(e);
	}
}

function gen()
{
	document.getElementById('id').value = genID();
}

function printEnrollments()
{
	var dat = document.getElementById('enrollments').innerHTML;
	var xmlhttp;
		if(window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		} else
		{// code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//document.getElementById("classes").innerHTML=xmlhttp.responseText;
				window.open('enrollments.html');
			}
		}
		xmlhttp.open("GET","enrolReport.php?dat="+dat,true);
		xmlhttp.send();
}

function delClassStudent(str, clas, yr)
{
	if(window.confirm('Remove '+str+' from Class?'))
	{
		var xmlhttp;
		if(window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		} else
		{// code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//document.getElementById("classes").innerHTML=xmlhttp.responseText;
				window.location.reload();
			}
		}
		xmlhttp.open("GET","delClassStudent.php?s="+str+"&c="+clas+"&yr="+yr,true);
		xmlhttp.send();
	}
}

function deleteFee(str, feeid)
{
	if(window.confirm('Delete '+str+' Fee?'))
	{
		var xmlhttp;
		if(window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		} else
		{// code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//document.getElementById("classes").innerHTML=xmlhttp.responseText;
				window.location="viewFees.php?e="+xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","deleteFee.php?name="+feeid,true);
		xmlhttp.send();
	}
}

function verifyPass()
{
	var pass1=document.getElementById('pass1').value;
	var pass2=document.getElementById('pass2').value;
	if(pass1==pass2 && pass1!="")
	{
		document.getElementById('passMisMatch').innerHTML="<h4 class='green'>macthed!</h4>";
		document.getElementById('password').value=pass1;
	} else 
	{
		document.getElementById('passMisMatch').innerHTML="<h4>Password mismatch!</h4>";
		document.getElementById('password').value="";
	}
}

function emailValidation(email){
	var crucialAt = email.lastIndexOf("@");
	var crucialDot = email.lastIndexOf(".");
	if((crucialAt <= -1) || (crucialDot <= -1)){
		document.getElementById("email").innerHTML=" invalid email";
		}
	else if((crucialAt >= crucialDot)){
		document.getElementById("email").innerHTML=" invalid email";
		}
		else {
			document.getElementById("email").innerHTML="";
			}
}

function showHideClasses() {
	/*if(document.getElementById('stu_classes').innerHTML!="") {
		clases=document.getElementById('stu_classes').innerHTML;
		document.getElementById('stu_classes').innerHTML="";
	} else {
		document.getElementById('stu_classes').innerHTML=clases;
	}
	*/
	try {
		$('#stu_classes').slideToggle();
	} catch(e) {
		alert(e);
	}
	return false;
}

function showHidePayments() {
	
	try {
		$('#stu_payments').slideToggle();
	} catch(e) {
		alert(e);
	}
	return false;
}

function showHideDetails() {
	showHideClasses();
	showHidePayments();
}

function showHint(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("classes").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadClasses.php?q="+str,true);
xmlhttp.send();
}

function loadRStudents(str, yr)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("students").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadRStudents.php?c="+str+"&yr="+yr,true);
xmlhttp.send();
}

function loadSResults(str)
{
	var yr=document.getElementById("year").value;
	var trm=document.getElementById("term").value;
	var clas=document.getElementById("class_name").value;
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("dispResults").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadSResults.php?s="+str+"&yr="+yr+"&trm="+trm+"&c="+clas,true);
xmlhttp.send();
}

function loadStudentID(str)
{
	if(str!=""){
	document.getElementById('stu_id').innerHTML=str;
	} else {
		document.getElementById('stu_id').innerHTML="00000000";
	}
}

function loadStudentClasses(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("classes").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadStudentClasses.php?q="+str,true);
xmlhttp.send();
}

function loadResultClasses(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("classes").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadResultClasses.php?q="+str,true);
xmlhttp.send();
}

function loadClassTeacherDetails(str)
{
	getNRC(str);
	var section = document.getElementById('year_grade').value;
	loadTeacherClasses(section);
}

function loadTeacherClasses(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("classes").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadTeacherClasses.php?s="+str,true);
xmlhttp.send();
}

function loadClassSubjects(str)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("class_subjects").innerHTML=xmlhttp.responseText;
	document.getElementById("students").innerHTML="";
	
    }
  }
xmlhttp.open("GET","loadClassSubjects.php?c="+str,true);
xmlhttp.send();
}

function loadResultSubjects(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("subjects").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadResultSubjects.php?c="+str,true);
xmlhttp.send();
}

function loadResultStudents(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("students").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadResultStudents.php?c="+str+"&yr="+document.getElementById('year').value,true);
xmlhttp.send();
}

function loadResultData(str)
{
	loadResultStudents(str);
	loadResultSubjects(str);
}

function loadOpSubjects(str)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("op_subjects").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadOpSubjects.php?c="+str,true);
xmlhttp.send();
}

function loadClassStudents(str, yr)
{
	//if(document.getElementById("students").innerHTML==""){
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("students").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadClassStudents.php?class="+str+"&yr="+yr,true);
xmlhttp.send();
	/*} else {
		document.getElementById("students").innerHTML="";
	}*/
}

function showStudents() {
	try {
		$('#students').slideToggle();
	} catch(e) {
		alert(e);
	}
	return false;
}

function showMsg(msgID, msID) {
	try {
		$('#'+msID).slideToggle();
		$('#'+msgID).slideToggle();
	} catch(e) {
		alert(e);
	}
	return false;
}

function getNRC(str)
{
    document.getElementById("txtNRC").innerHTML="NRC# "+str;
}

function loadSubjects(str)
{
	var teacher=document.getElementById('teacher').value
	var xmlhttp;
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("subjects").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadSubjects.php?c="+str+"&t="+teacher,true);
xmlhttp.send();
}

function unAssSub(subject)
{
    //document.getElementById("txtNRC").innerHTML="NRC# "+str;
	var teacher;
	teacher=document.getElementById("teacher").value;
	var clas=document.getElementById("class_name").value;
	var xmlhttp;
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("unassgnd").innerHTML=subject+" unassigned";
	getNRC(teacher);
    }
  }
if(window.confirm("Unassign "+subject+"?")){
xmlhttp.open("GET","unAssClassSubTeacher.php?t="+teacher+"&s="+subject+"&c="+clas,true);
xmlhttp.send();
} else {
	document.getElementById(subject).checked="checked";
}
}

function unAssClassTeacher(clas)
{
    //document.getElementById("txtNRC").innerHTML="NRC# "+str;
	var teacher;
	teacher=document.getElementById("teacher").value;
	var xmlhttp;
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("unassgnd").innerHTML=clas+" unassigned";
	loadClassTeacherDetails(teacher);
    }
  }
if(window.confirm("Unassign "+clas+"?")){
xmlhttp.open("GET","unAssClassTeacher.php?t="+teacher+"&c="+clas,true);
xmlhttp.send();
} else {
	document.getElementById(clas).checked="checked";
}
}

function unAssClassSub(subject, clas)
{
	var xmlhttp;
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    //document.getElementById("").innerHTML=subject+" unassigned";
	loadClassSubjects(clas);	
	//getNRC(teacher);
    }
  }
if(window.confirm("Unassign "+subject+"?")){
xmlhttp.open("GET","unAssClassSub.php?c="+clas+"&s="+subject,true);
xmlhttp.send();
} else {
	document.getElementById(subject).checked="checked";
}
}

function loadPayments()
{
	var yr=document.getElementById('year').value;
	var fee=document.getElementById('fee').value;
	var grade=document.getElementById('grade').value;
	var clas=document.getElementById('class').value;
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("payRecords").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","loadPayments.php?yr="+yr+"&f="+fee+"&g="+grade+"&c="+clas,true);
xmlhttp.send();
}

function editSubject(nam, des)
{
	try {
		document.getElementById('name').value=nam;
		document.getElementById('name1').value=nam;
		document.getElementById('description').innerHTML=des;
		$('#editSub').slideToggle();
	} catch(e) {
		alert(e);
	}
}
