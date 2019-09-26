<?php

date_default_timezone_set('America/Santiago'); 
//$date=date("Y-m-d");

if(isset($_POST['query']) && $_POST['query']>0){
    $date = date('Y-m-d', strtotime($date. ' + '.$_POST['query'].' days'));
    echo $date;
}else if(isset($_POST['query']) && $_POST['query']<0){
    $date = date('Y-m-d', strtotime($date. ' - '.abs($_POST['query']).' days'));
    echo $date;
}else 
{
    $date=date("Y-m-d");
    echo $date;
}

$diadelasemana = date("w", strtotime($date)); //obtiene el dia de la semana en valor numerico de domingo a sabado - 0 a 6
$fechainicial = date_create('2019-07-29');
$fechaactual = date_create($date);
$interval = date_diff($fechainicial, $fechaactual);
$week = $interval->format('%a') / 7;
$week = (round($week,1)); 

while($week >= 8)
{
    $week = $week - 8;
}
$especialista = array("Paula Pincheira","Paola Canadell","Larisa Suarez","Miriam Bravo","Victor Perez","CC","Jesus Ramirez","DD");



$url = 'turnositc.json'; // ruta del archivo JSON con los turnos de 8 semanas
$data = file_get_contents($url); // se abre el archivo JSON para lectura
$turnositc = json_decode($data); // interpretacion de la informacion del archivo JSON
$turnos = explode(",",$turnositc[$week]->$diadelasemana); //separacion de los turnos del dia, se usa la coma como caracter de separacion

$turnoM = array();
$turnoT = array();
$turnoN = array();
$turnoMN = array();
$turnoD = array();
$libre = array();

for($i=0;$i<8;$i++){

    if($turnos[$i]=="M"){
        array_push($turnoM, $especialista[$i]);
    }elseif ($turnos[$i]=="T"){
        array_push($turnoT, $especialista[$i]);
    }elseif($turnos[$i]=="N"){
        array_push($turnoN, $especialista[$i]);
    }elseif($turnos[$i]=="MN"){
        array_push($turnoMN, $especialista[$i]);
    }elseif($turnos[$i]=="D"){
        array_push($turnoD, $especialista[$i]);
    }elseif($turnos[$i]=="L"){
        array_push($libre, $especialista[$i]);    
    }
}

    if($_SERVER["REQUEST_METHOD"] == "POST") {    


       echo '<table>';
       echo '<thead>';
       echo '<tr><th id="horario">Horario</th><th id="nombres" colspan = 4>Nombres</th></tr></thead><tr>';
       echo '<td>07:00 a 14:00</td>';
       
        foreach ($turnoM as &$valor) {
            echo '<td>';
            echo $valor;
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '13:00 a 22:00';
        echo '</td>';
        foreach ($turnoT as &$valor) {
            echo '<td>';
            echo $valor;
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '22:00 a 08:00';
        echo '</td>';
        foreach ($turnoN as &$valor) {
            echo '<td>';
            echo $valor;
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'MN -';
        echo '</td>';
        foreach ($turnoMN as &$valor) {
            echo '<td>';
            echo $valor;
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'D';
        echo '</td>';
        foreach ($turnoD as &$valor) {
            echo '<td>';
            echo $valor;
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'Dia Libre';
        echo '</td>';
        foreach ($libre as &$valor) {
            echo '<td>';
            echo $valor;
            echo '</td>';
        }
        echo '</tr>';
        echo '</table>';
       
    


    }
?>