<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php
	


	echo "<div>Hello World</div>";

	echo "<div>Goodbye World</div>";


	//Variables

	$a = 5;

	echo $a;

	//String Interpolation
	echo "<div>I have $a things</div>";
	echo '<div>I have $a things</div>';


	// Number
	// Integer
	$b = 15;
	// Float
	$b = 0.576;

	$b = 10;

	// String
	$name = "Yerguy2";

	// Boolean
	$isOn = true;

	// Math
	// PEMDAS

	echo 5 + 4 * 2;

	// Concatenation
	echo "<div>b + a" . " = c</div>";
		echo "<div>$b + $a = ".($a + $b)."</div>";





	?>

<hr>
<div>This is my name</div>
<div>
	<?php

	$firstname = "Hamilton";
	$lastname = "Cline";
	$fullname = $firstname.".".$lastname;

	echo $fullname;

	?>

	<hr>
	<?php

	// superglobal
	// ?name =Serah
	
	$nameGet = isset($_GET['name']) ? $_GET['name'] : '';
	echo "<div>My name is {$nameGet}</div>";
	echo "<div>My name is {$nameGet}</div>";

	$colors = ["red"];
	$colorsAssociative = ["red" => "#ff0000"];
	$colorsObject = (object)["red" => "#ff0000"];

	// Object Property Notation
	echo $colorsObject->red."<br>";
	echo $colorsObject->{$colors[0]}."<br>";




	?>


	<hr>

<?php

print_r($colors);
echo "<hr>";
print_r($colorsAssociative);
echo "<hr>";

echo "<pre>";
print_r($colorsObject);
echo "</pre>";

// Function
function print_p($v) {
	echo "<pre>";
	print_r($v);
	echo "</pre>";
}

print_p($_GET);

?>



</body>
</html>