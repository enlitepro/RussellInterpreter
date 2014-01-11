<?php

include_once 'RussellInterpreter/Interpreter.php';
include_once 'RussellInterpreter/Lexer.php';
include_once 'RussellInterpreter/ParserTree.php';

$extensions = array(
    'Assignment' => array('var', 'variable', 'assignment', 'assign'),
    'Summation' => array('sum', 'summation'),
    'Subtraction' => array('minus', 'subtraction'),
    'Division' => array('div', 'division'),
    'Multiplication' => array('multi', 'multiplication'),
    'Random' => array('rand', 'random'),
    'Arr' => array('arr', 'array'),
);


$code = <<<EOD
variable(result, test(0, 10))
variable(x, test(0, result))
test(summation, test(test(test(2, 3),test(4, 5)),5))
subtraction(subtraction, test(10, 100))
division(division, test(10, 100))
multiplication(multiplication, test(2, 2, 2))
array(array, test(summation, subtraction, division, multiplication))
EOD;

$lexer = new RussellInterpreter\Lexer(array(
    'parser_tree' => new RussellInterpreter\ParserTree(),
));
$parserTree = $lexer->code($code);
var_dump($parserTree); die();

$interpreter = new RussellInterpreter\Interpreter(array(
    'extensions' => $extensions,
));
$interpreter->setVariable('x', 100);

foreach ($extensions as $file => $synonyms) {
    include_once "Extension/{$file}.php";
    $class = "RussellInterpreter\\Extension\\{$file}";
    $extension = new $class();
    $interpreter->addExtension($synonyms, $extension);
}

$isComplete = $interpreter->execute($parserTree);

if ($isComplete) {
    $variables = $interpreter->getVariables();
    var_dump($variables);
}
else {
    $errors = $interpreter->getErrors();
    var_dump($errors);
}