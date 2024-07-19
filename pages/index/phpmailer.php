<?php
$to="prajwalbhattarai80@gmail.com";
$subject="PHP Mail Function Test";
$message= "Hello";
$from="nabeen2058@gmail.com";
$header= "From:$from";
mail($to,$subject,$message,$header);
echo"Mail Sent";
?>