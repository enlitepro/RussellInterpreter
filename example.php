<?php

include_once 'RussellInterpreter/Interpreter.php';
include_once 'RussellInterpreter/Lexer.php';
include_once 'RussellInterpreter/ParserTree.php';

$code = <<<EOD
variable(result, rand(0, 10))
variable(x, rand(0, result))
assign(summation, sum(sum(sum(2, 3),sum(4, 5)),5))
assign(subtraction, subtraction(10, 100))
assign(division, division(10, 100))
assign(multiplication, multiplication(2, 2, 2))
assign(array, array(summation, subtraction, division, multiplication))
EOD;

$lexer = new RussellInterpreter\Lexer(array(
    'parser_tree' => new RussellInterpreter\ParserTree(),
));
$parserTree = $lexer->code($code);

$extensions = array(
    'Assignment' => array('var', 'variable', 'assignment', 'assign'),
//    'Test' => array('test'),
    'Summation' => array('sum', 'summation'),
    'Subtraction' => array('minus', 'subtraction'),
    'Division' => array('div', 'division'),
    'Multiplication' => array('multi', 'multiplication'),
    'Random' => array('rand', 'random'),
    'Arr' => array('arr', 'array'),
);

foreach ($extensions as $file => $synonyms) {
    include_once "RussellInterpreter/Extension/{$file}.php";
    $class = "RussellInterpreter\\Extension\\{$file}";
    $extension = new $class();
//    $interpreter->addExtension($synonyms, $extension);
    $extensions[$file] = array(
        'object' => $extension,
        'synonyms' => $synonyms,
    );
}

$interpreter = new RussellInterpreter\Interpreter(array(
    'extensions' => $extensions,
));

//$interpreter->setVariable('x', 100);

$isComplete = $interpreter->execute($parserTree);
//var_dump($interpreter->getVariables()); die(); //4:55

if ($isComplete) {
    $variables = $interpreter->getVariables();
    var_dump($variables);
}
else {
    $errors = $interpreter->getErrors();
    var_dump($errors);
}