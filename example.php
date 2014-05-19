<html><head>
<style type="text/css">
body {background:#000000; color:white;}
a:link {color:#FF0000;}      /* unvisited link */
a:visited {color:#FF0000;}  /* visited link */
a:hover {color:#00FF00;}  /* mouse over link */
a:active {color:#FF0000;}  /* selected link */
 table.center {
    margin-left:auto; 
    margin-right:auto;
font-size:28 pt;
  }
</style>
</head>
<body>
<?php

//check the GET action var to see if an action is to be performed
if (isset($_GET['action'])) {
	//Action required
	
	//Load the serial port class
	require("php_serial.class.php");
	
	//Initialize the class
	$serial = new phpSerial();

	//Specify the serial port to use... in this case COM1
	$serial->deviceSet("/dev/ttyUSB0");

	//Set the serial port parameters. The documentation says 9600 8-N-1, so
	$serial->confBaudRate(9600); //Baud rate: 9600
	$serial->confParity("none");  //Parity (this is the "N" in "8-N-1")
	$serial->confCharacterLength(8); //Character length (this is the "8" in "8-N-1")
	$serial->confStopBits(1);  //Stop bits (this is the "1" in "8-N-1")
	$serial->confFlowControl("none"); //Device does not support flow control of any kind, so set it to none.

	//Now we "open" the serial port so we can write to it
	$serial->deviceOpen();

	//Issue the appropriate command according to the serial relay board documentation
	if ($_GET['action'] == "on") {
		//to turn relay number 1 on, we issue the command 
		$serial->sendMessage("1\r\n"); //$serial->sendMessage("N1\r");
		$file = fopen("testFile.txt","w");
		fwrite($file, "1");
		fclose($file);

	} else if ($_GET['action'] == "off") {
		//to turn relay number 1 off, we issue this command
		$serial->sendMessage("0\r\n"); //$serial->sendMessage("F1\r");
		$file = fopen("testFile.txt","w");
		fwrite($file, "0");
		fclose($file);
}
	
	//We're done, so close the serial port again
	$serial->deviceClose();

}

?>
<table border="1" class="center">
<tr>
<th>Light 1</th>
<tr>
<td>
<pre>
.----------.
|   <a href="<?=$_SERVER['PHP_SELF'] . "?action=on" ?>">~ON~</a>   |
<?php
$file = fopen("testFile.txt", "r") or exit("Unable to open file!");
        if (fgetc($file)==1)
                echo "|   ____   |
|  |./[_]  |
|  |//  /  |
|  |/__/|  |
|  ||  ||  |
|  ||__||  |
|  |____|  |
";

        else
                echo "|   ____   |
|  |.--.|  |
|  ||  ||  |
|  ||__||  |
|  ||\ \|  |
|  |\ \_\  |
|  |_\[_]  |
";
fclose($file);
?>
|          |
|  <a href="<?=$_SERVER['PHP_SELF'] . "?action=off" ?>">~OFF~</a>   |
'----------'
</pre>
</td>
</tr>
</table>
</body>
</html>
