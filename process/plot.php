<?php 

    function fixDays($array)
    {
        for ($i=0; $i < count($array); $i++) { 
            switch ($array[$i]) {
                case 'Monday':
                    $array[$i] = 'Lundi';
                    break;
                case 'Tuesday':
                    $array[$i] = 'Mardi';
                    break;
                case 'Wednesday':
                    $array[$i] = 'Mercredi';
                    break;
                case 'Thursday':
                    $array[$i] = 'Jeudi';
                    break;
                case 'Friday':
                    $array[$i] = 'Vendredi';
                    break;      
                case 'Saturday':
                    $array[$i] = 'Samedi';
                    break;  
                case 'Sunday':
                    $array[$i] = 'Dimanche';
                    break;  
            }        
        }
        return $array;
    }



    function plotLastWeek($id) {
    $jour = date("Y-m-d"); 
    for ($i=0; $i < 7; $i++) { 
        $day = date('Y-m-d', strtotime($jour. ' - '.$i.' days'));
        $date[$i] = date('l',strtotime($day));
        $durees[$i] = dureeJour($id,$day);                            
        list($hour,$minute,$second) = explode(':', $durees[$i]);
        $data[$i] = $hour;
        $data[$i] += $minute/60;
        $data[$i] = round($data[$i], 2);   
    }
    $date = fixDays($date);
    $barChartData = array('labels' => array($date[6], $date[5], $date[4], $date[3], $date[2], $date[1], $date[0]), 
                          'datasets' => array(array('fillColor' => "rgba(151,187,205,0.5)", 
                                             'strokeColor' => "rgba(151,187,205,1)", 
                                             'data' => [$data[6], $data[5], $data[4], $data[3], $data[2], $data[1], $data[0]]),
                                        
                                        array('fillColor' => "rgba(220,220,220,0.5)", 
                                              'strokeColor' => "rgba(220,220,220,1)", 
                                              'data' => [$data[6], $data[5], $data[4], $data[3], $data[2], $data[1], $data[0]])

     ) );
    return $barChartData;
}