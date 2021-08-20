<?php
//exit();
if(isset($_REQUEST['git'])){
	if($_REQUEST['git'] == 'push')
		echo shell_exec("sudo sh -c 'cd /var/www/html/etribunalv2 && git pull'");
} else {
	echo "Webhook!";
}
