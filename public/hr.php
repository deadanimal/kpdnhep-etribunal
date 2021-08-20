<pre>
$con=mysqli_connect("10.23.155.148","etribunalV2","[tr1bunalDB@kpdnkk]") or die("Unable to access database");

// Migrate DDSA to eTribunal
$list = mysqli_query($con, "SELECT rvn_desc,rvn_district  FROM ttpm_etribunal.t_ref_venue");

$arr = array();

while($data = mysqli_fetch_assoc($list)) {

	$hearing_room = $data['rvn_desc'];
	$district = $data['rvn_district'];

	$district_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT rds_desc FROM ttpm_etribunal.t_ref_district WHERE rds_id='{$district}'"))['rds_desc'];

	$hearing_venue_id = mysqli_fetch_assoc(mysqli_query($con, "SELECT hearing_venue_id FROM etribunalV2.master_hearing_venue WHERE hearing_venue LIKE '%{$district_name}%'"))['hearing_venue_id'];

	//mysqli_query($con, "UPDATE `etribunalv2_2`.`master_hearing_room` SET `hearing_venue_id`={$hearing_venue_id}  WHERE hearing_room='{$hearing_room}' ");

	array_push($arr, $hearing_venue_id);
}

foreach($arr as $i=>$hearing_venue_id) {

	mysqli_query($con, "UPDATE `etribunalV2`.`master_hearing_room` SET `hearing_venue_id`={$hearing_venue_id}  WHERE hearing_room_id='".($i+1)."' ");
}

echo 'Done!';

</pre>
