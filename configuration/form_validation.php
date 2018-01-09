<?php 
class Form
{
   var $values = array();  //Holds submitted form field values
   var $errors = array();  //Holds submitted form error messages
   var $num_errors;   //The number of errors in submitted form

   /* Class constructor */
   function Form(){
      /**
       * Get form value and error arrays, used when there
       * is an error with a user-submitted form.
       */
      if(isset($_SESSION['value_array']) && isset($_SESSION['error_array'])){
         $this->values = $_SESSION['value_array'];
         $this->errors = $_SESSION['error_array'];
         $this->num_errors = count($this->errors);

         unset($_SESSION['value_array']);
         unset($_SESSION['error_array']);
      }
      else{
         $this->num_errors = 0;
      }
   }

   /**
    * setValue - Records the value typed into the given
    * form field by the user.
    */
   function setValue($field, $value){
      $this->values[$field] = $value;
   }

   /**
    * setError - Records new form error given the form
    * field name and the error message attached to it.
    */
   function setError($field, $errmsg){
      $this->errors[$field] = $errmsg;
      $this->num_errors = count($this->errors);
   }

   /**
    * value - Returns the value attached to the given
    * field, if none exists, the empty string is returned.
    */
   function value($field){
      if(array_key_exists($field,$this->values)){
         return htmlspecialchars(stripslashes($this->values[$field]));
      }else{
         return "";
      }
   }

   /**
    * error - Returns the error message attached to the
    * given field, if none exists, the empty string is returned.
    */
   function error($field){
      if(array_key_exists($field,$this->errors)){
         return "<font size=\"2\" color=\"#ff0000\">".$this->errors[$field]."</font>";
      }else{
         return "";
      }
   }

   /* getErrorArray - Returns the array of error messages */
   function getErrorArray(){
      return $this->errors;
   }  
   
   function checkNotEmpty($field){
      if($field!='0'&&(!$field || strlen(trim($field)) == 0)) return false; 	
	  else return true;
   }
   function checkAlphaNumeric($field){
	   if(!preg_match("/^([0-9a-z])*$/i", $field)) return false;
	   else return true;
   }
   function checkEmail($field){
	    $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$/i";
         if(!preg_match($regex,$field)) return false;
		 else return true;
}
function checkNumber($field){
	$field=str_replace(' ', '', $field);
	return is_numeric($field);
}
function checkPositiveNumber($field){
	if($this->checkNumber($field)) return $field>=0;
	else return false;		
}
function checkInteger($field){
	if($this->checkNumber($field)&& strpos($field,'.')==false) return true;
	else return false;
}
function checkPositiveInteger($field){
	if($this->checkInteger($field)) return $field>=0;
	else return false;
}
function checkNRC($field){
	$regex="/^[0-9]{6}\/[0-9]{2}\/[0-9]{1}$/i";
	$field=trim($field);
	if(!preg_match($regex,$field)) return false;
		 else return true;
}
function matchPasswords($pass1, $pass2){
	if($pass1!=$pass2) return false;
	else return true;
}
function validateDate($year, $month, $day){
	return checkdate((int)$month, (int)$day, (int)$year);
}
function dateIsAfter($year1, $month1, $day1, $year2, $month2, $day2){
	if((int)$year1>(int)$year2) return true;
	else if((int)$year1==(int)$year2&&(int)$month1>(int)$month2) return true;
	else if((int)$year1==(int)$year2&&(int)$month1==(int)$month2&&(int)$day1>(int)$day2) return true;
	else return false;
}
function slashify($field){
	if(PHP_VERSION < 6 && !get_magic_quotes_gpc()) return addslashes($field);
	else return $field;
}
}
$form = new Form;
?>
