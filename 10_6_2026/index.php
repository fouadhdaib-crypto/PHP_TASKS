<?php

$colors = array("red", "green", "blue", "yellow");
sort($colors);


foreach ($colors as $color) {


    echo "<h1>" . $color . "</h1> <br>";
}


$cities = array(
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid"
);



echo  "<h1>The capital of Italy is " . $cities["Italy"] . "</h1> <br/>";

echo  "<h1>The capital of Slovenia is " . $cities["Slovenia"] . "</h1> <br/>";



 $color = array (4 => 'white', 6 => 'green', 11=> 'red');


 print_r($color[4]);


 $arr = [1, 2, 3, 4, 5];



 array_splice($arr,3,0, "$");
echo implode(" ",$arr);



$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

arsort($fruits);

print_r("<br>");

print_r($fruits);


$numbers = [
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64,
    76, 63, 75, 76, 73, 68, 62, 73, 72, 65,
    74, 62, 62, 65, 64, 68, 73, 75, 79, 73
];


arsort($numbers);

$avg  =array_sum($numbers)/count($numbers);

print_r("<br>");

print_r("avg =  ".$avg);

print_r("<br>");

$low = array_slice($numbers,0,6);

$High = array_slice($numbers,25,count($numbers));


print_r("<br>");

echo implode($High);


print_r("<br>");

print_r($low);




$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);



$array3 = array_merge($array1, $array2);

print_r("<br>");        

echo implode(" ",$array3);




$colors = array("red", "blue", "white", "yellow");

function upperCase($arr) {
    foreach ($arr as &$color) {
        $color = strtoupper($color);
    }

    return $arr;
}

$result = upperCase($colors);

print_r($result);



$num = 3;
$prime = true;

if ($num < 2) {
    $prime = false;
}

for ($i = 2; $i < $num; $i++) {
    if ($num % $i == 0) {
        $prime = false;
        break;
    }
}

if ($prime) {
    echo "$num is a prime number";
} else {
    echo "$num is not a prime number";
}


print_r("<br>"); 


$str = "FUAD";

$revst = strrev($str);

echo $revst;



function swap(&$x, &$y) {
    $temp = $x;
    $x = $y;
    $y = $temp;
}

$x = 12;
$y = 10;

swap($x, $y);

echo "x = $x<br>";
echo "y = $y";


function isArmstrong($num) {
    $original = $num;
    $sum = 0;

    while ($num > 0) {
        $digit = $num % 10;
        $sum = $sum + ($digit * $digit * $digit);
        $num = intdiv($num, 10);
    }

    if ($sum == $original) {
        echo "$original is Armstrong Number";
    } else {
        echo "$original is not Armstrong Number";
    }
}

isArmstrong(407);

function isPalindrome($text) {

    // Remove spaces and punctuation
    $text = strtolower($text);
    $text = preg_replace("/[^a-z0-9]/", "", $text);

    // Reverse the string
    $reverse = strrev($text);

    if ($text == $reverse) {
        echo "Yes it is a palindrome";
    } else {
        echo "No it is not a palindrome";
    }
}

isPalindrome("Eva, can I see bees in a cave?");


function removeDuplicates($array) {
    return array_unique($array);
}

$array1 = array(2, 4, 7, 4, 8, 4);

$array1 = removeDuplicates($array1);

print_r($array1);

function checkSum($firstInteger, $secondInteger) {
    if ($firstInteger + $secondInteger == 30) {
        return $firstInteger + $secondInteger;
    }

    return false;
}

$result = checkSum(10, 10);

var_dump($result);

$number = 20;

if ($number % 3 == 0) {
    echo "true";
} else {
    echo "false";
}

$number = 50;

if ($number >= 20 && $number <= 50) {
    echo "true";
} else {
    echo "false";
}


$numbers = [1, 5, 9];

echo max($numbers);


$units = 300;
$bill = 0;

if ($units <= 50) {
    $bill = $units * 2.50;
} elseif ($units <= 150) {
    $bill = (50 * 2.50) + (($units - 50) * 5.00);
} elseif ($units <= 250) {
    $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);
} else {
    $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);
}

echo "Electricity Bill = " . $bill . " JOD";


$num1 = 10;
$num2 = 5;
$operator = "*";

if ($operator == "+") {
    echo $num1 + $num2;
} elseif ($operator == "-") {
    echo $num1 - $num2;
} elseif ($operator == "*") {
    echo $num1 * $num2;
} elseif ($operator == "/") {
    echo $num1 / $num2;
} else {
    echo "Invalid operator";
}



$age = 15;

if ($age >= 18) {
    echo "is eligible to vote";
} else {
    echo "is not eligible to vote";
}


$num = -60;

if ($num > 0) {
    echo "Positive";
} elseif ($num < 0) {
    echo "Negative";
} else {
    echo "Zero";
}



$scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];

$average = array_sum($scores) / count($scores);

if ($average >= 90) {
    $grade = "A";
} elseif ($average >= 80) {
    $grade = "B";
} elseif ($average >= 70) {
    $grade = "C";
} elseif ($average >= 60) {
    $grade = "D";
} else {
    $grade = "F";
}

echo "Average = " . $average . "<br>";
echo "Grade = " . $grade;

$number = range(1,10);


echo implode("%", $number);




$total = 0;

for ($i = 0; $i <= 30; $i++) {
    $total += $i;
}

echo $total;        

  echo "<br>";
   echo "<br>";













$array = [
    ['A', 'A', 'A', 'A', 'A'],
    ['A', 'A', 'A', 'B', 'B'],
    ['A', 'A', 'C', 'C', 'C'],
    ['A', 'D', 'D', 'D', 'D'],
    ['E', 'E', 'E', 'E', 'E']
];

for ($i = 0; $i < count($array); $i++) {

    for ($j = 0; $j < count($array); $j++) {
        echo $array[$i][$j] . " ";
    }

    echo "<br>";
}



$array = [
    ['1', '1', '1', '1', '1'],
    ['A', 'A', 'A', 'B', 'B'],
    ['A', 'A', 'C', 'C', 'C'],
    ['A', 'D', 'D', 'D', 'D'],
    ['E', 'E', 'E', 'E', 'E']
];

for ($i = 0; $i < count($array); $i++) {

    for ($j = 0; $j < count($array); $j++) {
        echo $array[$i][$j] . " ";
    }

    echo "<br>";
}



 echo "<br>";
  echo "<br>";




for ($i = 1; $i <= 5; $i++) {

    for ($j = 1; $j <= 5; $j++) {

        if ($j == $i) {
            echo $i . " ";
        } else {
            echo "0 ";
        }

    }

    echo "<br>";
}




































?>