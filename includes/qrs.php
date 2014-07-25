<?php
require_once('classes/database.php');
require_once('classes/infos.php');
require_once('classes/ouvrier.php');


function checkIn($qrcode)
{
	$valid =false;
	$ou = new Ouvrier();
	if($ou->find_by_qrcode($qrcode)) {
		$ou_data = $ou->get_ouvrier();
		date_default_timezone_set('Africa/Casablanca');
		$heure = date("H:i:s");
		$jour = date("Y-m-d");
		$infos = Infos::tous_infos_ouvrier($ou_data['o_id'], 1);
		if (!empty($infos)) {
            foreach ($infos as $info) {
                $in = new Infos();
                $b = strtotime($heure);
                if (!is_null($info['heure_fin']) || $jour != $info['i_jour']) {
                    $a = strtotime($info['heure_fin']);
                    if($b - $a > 1000 || $jour != $info['i_jour']) {

                        $info_data = array(
                            "i_jour"=>$jour,
                            "heure_debut"=>$heure,      
                            "o_id"=>$ou_data['o_id']
                        );
                        foreach ($info_data as $key => $value) {
                            $in->set_infos($key,$value);
                        }
                        $in->create();
                        $valid = true;
                    }
                } else {
                    
                    $a = strtotime($info['heure_debut']);
                    if($b - $a > 1000 || $jour != $info['i_jour']) {
                        
                        $in->find_by_id($info['i_id']);
                        $in->set_infos("heure_fin",$heure);
                        $in->update();                      
                        $valid = true;
                    }
                }
            }
        } else { //Condition for first entry
            $in = new Infos();
            $info_data = array(
                "i_jour"=>$jour,
                "heure_debut"=>$heure,      
                "o_id"=>$ou_data['o_id']
            );
            foreach ($info_data as $key => $value) {
                $in->set_infos($key,$value);
            }
            $in->create();
            $valid = true;
        }

        if ($valid) {
            echo '<div class="alert alert-info">
		            <h2><strong>Ok!</strong><br>Check-in enregistré pour l\'ouvrier ' . $ou_data['o_prenom']. ' '.$ou_data['o_nom'].
                        '.</h2><br> <br>
                    <a href="rapports.php?id='.$ou_data['o_id'].'" class="btn btn-primary">
                        &nbsp;
                        Rapport de cet ouvrier                      
                        <i class="icon-chevron-right"></i>
                    </a>
		        </div>';
		}
	}
}
