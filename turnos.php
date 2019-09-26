<!DOCTYPE html>
<html lang="en">
<head>
  <title>Turnos Datacenter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <link rel="stylesheet" href="turnos.css">  
  <script type="text/javascript">
$(document).ready( function(){
refreshAt(0,0,02); 
});

//funcion para recargar pagina a las 00:00
function refreshAt(hours, minutes, seconds) {
    var now = new Date();
    var then = new Date();
	 
    if(now.getHours() > hours ||
       (now.getHours() == hours && now.getMinutes() > minutes) ||
        now.getHours() == hours && now.getMinutes() == minutes && now.getSeconds() >= seconds) {
        then.setDate(now.getDate() + 1);

    }
    then.setHours(hours);
    then.setMinutes(minutes);
    then.setSeconds(seconds);

    var timeout = (then.getTime() - now.getTime());
    setTimeout(function() { window.location.reload(true); }, timeout);
    refreshAt(0,0,02);  
}
</script>


</head>
<body>

<?php
date_default_timezone_set('America/Santiago'); 
$date=date("Y/m/d");  // guarda la fecha del dia actual
$diadelasemana = date("w"); //obtiene el dia de la semana en valor numerico de domingo a sabado - 0 a 6
$especialista = array("Ivan Rosales","Mauricio Aspee","Vacante","Vacante","Gianinna Salazar","Jose Barrios","Derikson Urbano","Christian Peters","Vacante");

//matriz semana es de domingo a sabado - 0 a 6
$semana = array 
(
    array('LI','LI','T1','T2','LI','LI','T3','T1','T31'),
    array('T3','LI','T2','T1','T2','T31','T1','LI','T1'),
    array('T3','T2','T21','LI','T2','T3','T1','LI','T1'),
    array('T3','T2','LI','T1','T2','T3','LI','T2','T1'),
    array('T3','T2','LI','T1','T2','T3','T31','T2','T1'),
    array('LI','T2','T1','T1','T21','T3','T3','T21','T1'),
    array('LI','T21','T1','LI','LI','LI','T3','LI','LI')
    
);

$datetime1 = date_create('2018-12-24');
$datetime2 = date_create($date);
$interval = date_diff($datetime1, $datetime2);
$week = $interval->format('%a') / 7;
$week = round($week / 9 , 1);  
$week = (($week - floor($week))*10)-1;

$turno1 = array();
$turno2 = array();
$turno21 = array();
$turno3= array();
$turno31= array();
$libre  = array();


for ($i=0; $i<= 8; $i++){

    if($week == 9){
    $week=0;
    }
  
    if($semana[$diadelasemana][$week]=="T1"){
        array_push($turno1, $especialista[$i]);
    }elseif ($semana[$diadelasemana][$week]=="T2"){
        array_push($turno2, $especialista[$i]);
    }elseif($semana[$diadelasemana][$week]=="T21"){
        array_push($turno21, $especialista[$i]);
    }elseif($semana[$diadelasemana][$week]=="T3"){
        array_push($turno3, $especialista[$i]);
    }elseif($semana[$diadelasemana][$week]=="T31"){
        array_push($turno31, $especialista[$i]);
    }elseif($semana[$diadelasemana][$week]=="LI"){
        array_push($libre, $especialista[$i]);    
    }

    $week++;
}

?>

<table  class="center">
<tr>
<th class="horario">Horario</th>
<th colspan="3">Especialistas</th>
</tr>
</thead>
<tr>
<td>07:00 a 16:00</td>


<?php 
foreach ($turno1 as &$valor) {
    echo '<td>';
    echo $valor;
    echo '</td>';
}
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '14:55 a 23:55';
echo '</td>';
foreach ($turno21 as &$valor) {
    echo '<td>';
    echo $valor;
    echo '</td>';
}
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '15:00 a 24:00';
echo '</td>';
foreach ($turno2 as &$valor) {
    echo '<td>';
    echo $valor;
    echo '</td>';
}
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '23:00 a 08:00';
echo '</td>';
foreach ($turno3 as &$valor) {
    echo '<td>';
    echo $valor;
    echo '</td>';
}
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '00:00 a 09:00';
echo '</td>';
foreach ($turno31 as &$valor) {
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

?>

</body>
</html>