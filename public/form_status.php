<?php
$con=mysqli_connect("10.23.155.148","etribunalV2","[tr1bunalDB@kpdnkk]", 'etribunalV2') or die("Unable to access database");

// Migrate DDSA to eTribunal
$list = mysqli_query($con, "SELECT * FROM master_form_status");


while($data = mysqli_fetch_assoc($list)) {

	$id = $data['form_status_id'];
	$metakey = strtolower($data['status_code']);

	if(!mysqli_query($con, "UPDATE master_form_status SET `metakey`='{$metakey}' WHERE form_status_id={$id} "))
		echo mysqli_error($con);

}

echo mysqli_num_rows($list);

?>