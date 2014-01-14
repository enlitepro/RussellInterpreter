<?php

include_once 'RussellInterpreter/Interpreter.php';
include_once 'RussellInterpreter/Lexer.php';
include_once 'RussellInterpreter/ParserTree.php';

$code = <<<EOD
variable(result, rand(0, 10))
variable(x, rand(0, result))
assign(summation,
       sum(
           sum(
               sum(2, 3),
               sum(4, 5)
           ), 5
       )
)
assign(subtraction, subtraction(10, 100))
assign(division, division(10, 100))
assign(multiplication, multiplication(2, 2, 2))
assign(array, array(
    summation,
    subtraction,
    division,
    multiplication
))
cycle(not_equal(i, 10),
    increment(i)
)
until(equal(i, 1),
    decrement(i)
)
var(rt, if(true, 'yes', 'no'))
var(rf, if(false, 'yes', 'no'))
EOD;

$lexer = new RussellInterpreter\Lexer(array(
    'parser_tree' => new RussellInterpreter\ParserTree(),
));
$parserTree = $lexer->code($code);

$extensions = array(
    'Assignment' => array('var', 'variable', 'assignment', 'assign'),
    'Summation' => array('sum', 'summation'),
    'Subtraction' => array('minus', 'subtraction'),
    'Division' => array('div', 'division'),
    'Multiplication' => array('multi', 'multiplication'),
    'Random' => array('rand', 'random'),
    'Arr' => array('arr', 'array'),
    'Cycle' => array('cycle', 'while'),
    'Until' => array('until'),
    'True' => array('isTrue', 'true'),
    'False' => array('isFalse', 'false'),
    'Increment' => array('increment'),
    'Decrement' => array('decrement'),
    'Equal' => array('equal'),
    'NotEqual' => array('notequal', 'not_equal', 'neq'),
    'ConditionalOperator' => array('if'),
);

foreach ($extensions as $file => $synonyms) {
    include_once "RussellInterpreter/Extension/{$file}.php";
    $class = "RussellInterpreter\\Extension\\{$file}";
    $extension = new $class();
    $extensions[$file] = array(
        'object' => $extension,
        'synonyms' => $synonyms,
    );
}

$interpreter = new RussellInterpreter\Interpreter(array(
    'extensions' => $extensions,
));

$isComplete = $interpreter->execute($parserTree);

echo ($isComplete ? 'COMPLETE!' : 'NOT COMPLETE, NO FUTURE') . PHP_EOL;
$variables = $interpreter->getVariables();
echo 'variable:' . PHP_EOL;
var_dump($variables);
echo 'errors:' . PHP_EOL;
$errors = $interpreter->getErrors();
var_dump($errors);