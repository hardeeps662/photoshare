<?php 
$lists=DateTimeZone::listIdentifiers();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Interview</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>

<form id="details">
<p><h3>Form</h3></p>
<p>First Name:</br><input type="text" name="fname"></p>
<p>Last Name:</br><input type="text" name="lname"></p>
<p>Email Name:</br><input type="text" name="em"></p>
<p>PIN CODE:</br><input type="text" name="pin"></p>
<input type="submit" name="">

<select>
    <?php


    foreach ($lists as $list ) {
      echo "<option value=\"$list\">".$list."</option>";
    }
   
    ?>
</select>
</form>



<?php 


   
     $dt=new DateTime();
     echo $dt->format('d-F-Y')."</br>";
          $default_tz=$dt->getTimezone();
          echo 'default timezone: '.$default_tz->getName() ."</br>";
      $custom_tz=new DateTimeZone('America/Vancouver');
      //echo $custom_tz->getName()."</br>";

      $dt->setTimezone($custom_tz);
      $custom=$dt->getTimezone();
      echo 'custom timezone: '.$custom->getName();
      echo $offset=$dt->getOffset()/(60*60)."<br>";
      echo $offset;
      $hour=floor($offset);
      $minute=$offset-$hour;
      echo $minute;
     // echo $dt->format('P');
       






?>
<script type="text/javascript">
	$(function(){
    $('#results').html('');
    $('#details').submit(function(){
            $('#results').html('Please Wait');
            $.post('action.php', $(this).serialize(), function(data){
            $('#results').html(data);     

    
             
        }).fail(function() {
             $('#results').html("<b>Error</b>");
        });
        return false;
    });
});
</script>

</body>
</html>