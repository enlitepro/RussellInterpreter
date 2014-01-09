<?php

include_once 'RussellInterpreter.php';

$interpreter = new RussellInterpreter\Interpreter();

$functions = array(
    'var'   => 'Variable',
    'sum'   => 'Summation',
    'minus' => 'Subtraction',
    'div'   => 'Division',
    'mult'  => 'Multiplication',
    'rand'  => 'Random',
    'arr'  => 'Arr',
);

foreach ($functions as $name => $file) {
    include_once "Method/{$file}.php";
    $class = "RussellInterpreter\\Method\\{$file}";
    $variable = new $class();
    $interpreter->addFunction($name, $variable);
}

$code = <<<EOD
var(result, rand(0, 10))
var(x, rand(0, result))
var(summation, sum(2, 5))
var(subtraction, minus(10, 100))
var(division, div(10, 100))
var(multiplication, mult(2, 2, 2))
var(array, arr(summation, subtraction, division, multiplication))
EOD;

// @todo Problem with method variable when variable is exist
//$interpreter->setVariable('x', 1);
//$interpreter->setVariable('y', 2);
$interpreter->setVariable('z', 100500);

try {
    $variables = $interpreter->code($code);
    $variables = $interpreter->code('var(z2, sum(z, 40, 3))');
}
catch (Exception $e) {
    echo $e;
}

var_dump($variables);