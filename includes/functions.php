<?php 

function escape($var) {
	return htmlEntities($var, ENT_QUOTES);
}

function getDuree($heured, $heuref) {
    if (!is_null($heuref)) {
        $hr = strtotime($heuref) - strtotime($heured);
        date_default_timezone_set('Africa/Casablanca');
        $hr = date("H:i:s", $hr);
    } else {
            $hr = ' -- ';
    }
    return $hr;
}

function getDureeInfo($iid) {
    $in = new Infos();
    $in->find_by_id($iid);
    $in_data=$in->get_infos();
    date_default_timezone_set('Africa/Casablanca');
    return getDuree($in_data['heure_debut'],$in_data['heure_fin']);
}

function sum_the_time($time1, $time2) {
  $times = array($time1, $time2);
  $seconds = 0;
  foreach ($times as $time)
  {
    list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  return "{$hours}:{$minutes}:{$seconds}";
}

function dureeJour($oid, $jour) {
    $ou = new Ouvrier();
    $ou->find_by_id($oid);
    $ou_data=$ou->get_ouvrier();
    $infos=Infos::tous_infos_ouvrier_jour($oid,$jour);
    $duree = '00:00:00';
    foreach ($infos as $info) {
        date_default_timezone_set('Africa/Casablanca');
        if (!is_null($info['heure_fin'])) {
            $durinfo = getDureeInfo($info['i_id']);
            $duree = sum_the_time($duree, $durinfo);
        }
    }
    date_default_timezone_set('Africa/Casablanca');
    return $duree;
}
