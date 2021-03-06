<?php
		require_once "../../connection.php";
    session_start();

		$id = $_POST['id'];
    $emp_id = $_SESSION['account']['emp_id'];
    $condition_id = $_POST['condition_id'];
    $new_location_id = $_POST['new_location_id'];
    $old_location_id = $_POST['old_location_id'];
		$dateToday = date('Y-m-d H:i:s');
		$remarks = $_POST['remarks'];
		//check if going to merge
		if ($db->has("property_accountability", [
			"AND" => [
				"property_id" => $id,
				"emp_id" => $emp_id,
				"condition_id" => $condition_id,
				"location_id" => $new_location_id
			]
		])) { //if employee want to change already exists in her/his accountabliity
			$qty = $db->get("property_accountability", "qty", [
				"AND" => [
					"property_id" => $id,
					"emp_id" => $emp_id,
					"condition_id" => $condition_id,
					"location_id" => $old_location_id
				]
			]);

			$db->update("property_accountability", ["qty[+]" => $qty], [
				"AND" => [
					'emp_id' => $emp_id,
					'property_id' => $id,
					'condition_id' => $condition_id,
					'location_id' => $new_location_id
				]
			]);

			$db->delete("property_accountability", [
				"AND" => [
					'emp_id' => $emp_id,
					'property_id' => $id,
					'condition_id' => $condition_id,
					'location_id' => $old_location_id
				]
			]);

			echo 2;
		} else { //else if not exists, just a simple update
			$db->update("property_accountability", ["location_id" => $new_location_id], [
				"AND" => [
					'emp_id' => $emp_id,
					'property_id' => $id,
					'condition_id' => $condition_id,
					'location_id' => $old_location_id
				]
			]);
			echo 1;
		}

		$db->update("transfer_request",["old_loc_id" => $new_location_id], [
			"AND" => [
				'emp_id' => $emp_id,
				'property_id' => $id,
				'condition_id' => $condition_id,
				'old_loc_id' => $old_location_id
			]
		]);
		// echo $id;
		// return;
  	$propertyName = $db->get("property",["pcode","sno","description","brand","uom","or_number"],["id"=>$id]);
		$oldLoc = $db->get("location","location",["id" => $old_location_id]);
		$newLoc = $db->get("location","location",["id" => $new_location_id]);
		$action =  $emp_id." updated the location of ".$propertyName['pcode']." from ".$oldLoc." to ".$newLoc;
		$db->insert("audit_trail_location",[
			"action" => $action,
			"date" => $dateToday,
			"pcode"=>$propertyName['pcode'],
			"sno"=>$propertryName['sno'],
			"brand"=>$propertyName['brand'],
			"uom"=>$propertyName['uom'],
			"remarks"=>$remarks,
			"po_number"=>$propertyName['or_number'],
			"property_id"=>$id,
			"description"=>$propertyName['description'],
			"actor"=>$emp_id,
			"old_location" => $oldLoc,
			"new_location" => $newLoc
		]);
?>
