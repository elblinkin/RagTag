<?php

namespace Raggle\PHPUnit\Classification;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestListener;
use PHPUnit_Framework_TestSuite;
use PHPUnit_Framework_Warning;
use PHPUnit_Util_Printer;
use PHPUnit_Util_Test;
use ReflectionMethod;

class Logger 
extends PHPUnit_Util_Printer
implements PHPUnit_Framework_TestListener {

    private $current_test_suite_name = '';
    private $current_test_name = '';
    private $current_test_status = 'executed';
    private $current_test_exception_message = '';

    public function __construct($out) {
        parent::__construct($out);
    }

    public function addError(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time) {

    }

    public function addFailure(
        PHPUnit_Framework_Test $test,
        PHPUnit_Framework_AssertionFailedError $e,
        $time) {

    }

    public function addIncompleteTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time) {

        $this->current_test_status = 'incomplete';
        $this->current_test_exception_msseage = $e->getMessage();
    }

    public function addSkippedTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time) {

        $this->current_test_status = 'skipped';
        $this->current_test_exception_message = $e->getMessage();
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {
        $this->current_test_suite_name = $suite->getName();
        $this->current_test_name = '';
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {
        $this->current_test_suite_name = '';
        $this->current_test_name = '';
    }

    public function startTest(PHPUnit_Framework_Test $test) {
        $this->current_test_name = PHPUnit_Util_Test::describe($test);
        $this->current_test_status = 'executed';
    }

    public function endTest(PHPUnit_Framework_Test $test, $time) {
        $annotations = array();
        $fileName = '';
        $startLine = -1;
        $endLine = -1;
        if (!$test instanceof PHPUnit_Framework_Warning) {
             $name = $test->getName(FALSE);
             $method_annotations = PHPUnit_Util_Test::parseTestMethodAnnotations(
                 get_class($test), $name);
             $annotation_types = 
                 array_unique(
                     array_merge(
                         (array) array_keys($method_annotations['class']),
                         (array) array_keys($method_annotations['method'])
                     )
                 );
             $annotations = array();
             foreach ($annotation_types as $type) {
                 $is_class_type = array_key_exists(
                     $type,
                     $method_annotations['class']
                 );
                 $is_method_type = array_key_exists(
                     $type,
                     $method_annotations['method']
                 );
                 if ($is_class_type && $is_method_type) {
                     $annotations[$type] = 
                         array_merge(
                             (array) $method_annotations['class'][$type],
                             (array) $method_annotations['method'][$type]
                         );
                 } else if ($is_class_type) {
                     $annotations[$type] = 
                         (array) $method_annotations['class'][$type];
                 } else if ($is_method_type) {
                     $annotations[$type] = 
                         (array) $method_annotations['method'][$type];
                 }
             }
             $method = new ReflectionMethod(get_class($test), $name);
             $fileName = $method->getFileName();
             $startLine = $method->getStartLine();
             $endLine = $method->getEndLine();
        }

        $this->write(
            array(
                'suite' => $this->current_test_suite_name,
                'test' => $this->current_test_name,
                'file_name' => $fileName,
                'start_line' => $startLine,
                'end_line' => $endLine,
                'exec_status' => $this->current_test_status,
                'annotations' => $annotations,
                'message' => $this->current_test_exception_message,
            )
        );
    }

    public function write($buffer) {
        parent::write(json_encode($buffer));
    }
}
