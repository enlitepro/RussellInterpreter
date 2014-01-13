<?php
/**
 * The interface for extension
 *
 * @category   Extension
 * @package    RussellInterpreter
 * @author     Vladimir Struts <Sysaninster@gmail.com>
 * @license    LICENSE.txt
 * @date       13.01.14
 */

namespace RussellInterpreter;


interface ExtensionInterface {

    /**
     * @param array $arguments
     * @param Interpreter $core
     * @return mixed
     */
    public function calculationArguments(array $arguments, Interpreter $core);

    public function execute(array $arguments, Interpreter $core);

} 