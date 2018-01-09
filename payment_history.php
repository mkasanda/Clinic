<?php
?>

<script type="text/javascript" >
function printPage()
{
   var html="<html>";
   html+= document.getElementById('print').innerHTML;
   html+="</html>";

   var printWin = window.open('','','left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>
<style>
	 h2{
		 font-size:11px;
		 line-height:22px;
		 color:#333;
		 font-weight:normal;
		 background-color:inherit;
		 font:normal 14px/14px "Times New Roman", Times, serif, Helvetica, sans-serif;
	 }
	 h2 span{
	     display:block;
		 font:normal 28px/28px "Times New Roman", Times, serif, Helvetica, sans-serif;
		 color:#111;
		 background-color:inherit;
	 }
	 table tr td {
		 padding:2px 5px;
	 }
</style>
<style>
	 h2{
		 font-size:11px;
		 line-height:22px;
		 color:#333;
		 font-weight:normal;
		 background-color:inherit;
		 font:normal 14px/14px "Times New Roman", Times, serif, Helvetica, sans-serif;
	 }
	 h2 span{
	     display:block;
		 font:normal 28px/28px "Times New Roman", Times, serif, Helvetica, sans-serif;
		 color:#111;
		 background-color:inherit;
	 }
	 table tr td {
		 padding:2px 5px;
	 }
</style>

<?php 

?>