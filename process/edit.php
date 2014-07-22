<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/ouvrier.php';
require_once '../classes/infos.php';

if(!empty($_POST['id_info'])) {
    
    $in = new Infos();
    $in->find_by_id($info['i_id']);
    $in->set_infos("heure_fin",$heure);
    $in->update();                      
    $valid = true;

}