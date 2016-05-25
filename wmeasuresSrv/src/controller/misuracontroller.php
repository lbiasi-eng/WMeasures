<?php
	
	/*$sensore = $_POST['s'];
	$username = $_POST['u'];
	$data = $_POST['d'];
	$tempo = $_POST['t'];
	$value= $_POST['v'];
	$luogo = $_POST['l'];
	*/
	include "../model/misura.php";
	
	$json = file_get_contents('php://input');
	$data = json_decode($json);

	$u= $data->{'u'};
	$op = $data->{'op'};
	
	if ($op=="write"){
		$elementCount = count($data->{'sensorsValue'});
		for($i = 0;$i<$elementCount ;$i++){
			$misura = new Misura();
			$misura->value = $data->{'sensorsValue'}[$i]->{'val'};
			$misura->descSensore = $data->{'sensorsValue'}[$i]->{'descr'};
			$misura->date = $data->{'sensorsValue'}[$i]->{'date'};
			$misura->time= $data->{'sensorsValue'}[$i]->{'time'};
			$misura->username = $u;
			$misura->aggiornaMisura();
		}
	}
	else if($op=="read"){//{"start": "17/10/2016", "op": "read", "end": "16/9/2016", "u": "l.biasi", "desc": ["Resistenza 20 ohm", "Fotoresistenza"]}
		$start = $data->{'start'};
		$end = $data->{'end'};
		$elementCount = count($data->{'desc'});
		$sensorList = array();
		for($i = 0;$i<$elementCount ;$i++){
			array_push($sensorList, "'".$data->{'desc'}[$i]."'");
		}
		$misura = new Misura();
		echo json_encode($misura->ottieniMisure($u, $start, $end, $sensorList));
	}
	
?>