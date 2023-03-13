<!DOCTYPE html>
<html>
<title>Car Clicks</title>

<!-- This script requires a file "carDB.txt" to be writeable from the web.-->

      <?php
         extract($_POST);  ##Grab whatever came from the form
   

//Figure out which car was clicked: Its _x (or _y) coordinate will be non-empty
       if($diavel_x !="") {$car = "Diavel";} 
         else if($testarossa_x !="") {$car = "Testarossa";} 
         else if($ford_x !="") {$car = "Ford";} 
         else if($fordGT_x !="") {$car = "FordGT";} 
         else if($Lambo_x !="") {$car = "Lambo";} 
         else if($LamboAvent_x !="") {$car = "LamboAvent";} 
         else if($Mcclaren_x !="") {$car = "McClaren";} 
         else if($Mustang_x !="") {$car = "Mustang";} 
         else if($Pagani_x !="") {$car = "Pagani";}
          
// or, you can do this with less code like this:
       foreach(array_keys($_POST) as $carclik)
  	{
 	  if (strpos($carclik, "_x") !== false) {  
	  //The name of the key $carclik contains an '_x'; this is the one clicked
	  //Since an image was clicked (for the form to have been submitted), only one
	  //car key will be submitted to this handler. So if we detected a key containing
	  //a '_x' then we found the key. Checking for non-empty value ($_POST["$carclik"] !="")
	  //is not even necessary (since we know one and only one image was clicked).

	  //So now remove the '_x' from the end of it to get the ID
	  $carclik = preg_replace("/_x/", "", $carclik);
	  break;
	  }
  	}	
	// At this point $carclik contains the name of the clicked car

//write this to the clicks DB File
         $writeline =  "{$name} clicked {$carclik}\n"; 
         $carDB = "carDB.txt";
         $fh = fopen($carDB, 'a');
         fwrite($fh, $writeline);
         fclose($fh); 

//Read the clicks file and produce the stats in a 2-dimensional associative array
         $data = file($carDB);
         foreach($data as $line){
		$parts = explode(" ", $line); //split the line at the spaces

		//Compute the stats and keep them in a 2-dimensional associative array.
		//The keys are "person" and "car". The value for key pair person/car is 
		//the number of times person clicked on car.

		$stat{$parts[0]}{$parts[2]}++; //increment the count for this pair
	  }
      ?>


<body>
   
<?php $script = $_SERVER['SCRIPT_NAME']; 
$script = preg_replace("/^.*\//", "", $script);
   echo "<form action=\"$script\" method=post>";?>

<!--This is the form where all the inputs happen-->
    What's your name?<input type ="text" name = "name" required>
    <hr>
    <h3>Pick a Car</h3>
    <table><tr>
    <td><input type="image" name="Diavel" src = "./cars/DucatiDiavel.jpg"> </td>
    <td><input type="image" name="Testarossa" src="./cars/FerrariTestarossa.jpg"> </td>
   <td> <input type="image" name="Ford" src="./cars/Ford.jpg">    </td> </tr>

    <tr><td><input type="image" name="FordGT" src ="./cars/FordGT.jpg ">   </td>
    <td><input type="image" name="Lambo" src = "./cars/Lamborghini.jpg"> </td>
    <td><input type="image" name="LamboAvent" src="./cars/LamborghiniAventador.jpg"> </td></tr>   
    
    <tr> <td><input type="image" name="Mcclaren" src="./cars/McLaren720S.jpg"> </td>
    <td><input type="image" name="Mustang" src="./cars/Mustang.jpg"> </td>
   <td> <input type="image" name="Pagani" src="./cars/Pagani_Zonda1999.jpg">    </td> </tr>
        </table>
        

    </form>
    <?php 
	//This is the loop that displays stats.
	foreach ($stat as $name => $etc){	
		foreach( $etc as $thecar => $clicks){
		if ($stat{$name}{$thecar} !=" "){
		print "$name clicked $thecar $clicks times<br>";}
		}}

      print "IP address is $_SERVER[REMOTE_ADDR]";

	?>
</body>

</html>