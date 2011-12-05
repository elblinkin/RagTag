<?php
require_once 'Autoload.php';
class Taggle_Git_Log_Processor implements Taggle_Document_Processor {

    private $store;
    
    function __construct(Taggle_Store $store) {
        $this->store = $store;
    }

    function process($log_output, $ref_id = null) {
        $documents = array();
        $log = null;
        foreach ($log_output as $line) {
            if ($log == null) {
                $log = json_decode($line);
                print "Log:";
                print_r($log);
                $log->ref_id = $ref_id;
                $log->files = array();
            } else if (empty($line)) {
                $documents[] = $log;
                $log = null;
            } else {
                $log->files[] = $line;
            }
        }
        if ($log != null) {
            $documents[] = $log;
        }
        return $this->store->batchSave($documents);
    }
}

/*$log_output = array(
    "{\"commit\": \"bc2dab8f5e8c1f122d160c8a8dcb7306e949ffb0\", \"author\": {\"name\": \"Laura Beth Lincoln\", \"email\": \"llincoln@etsy.com\", \"date\": \"1323114847\"}, \"committer\": {\"name\": \"Laura Beth Lincoln\", \"email\": \"llincoln@etsy.com\", \"date\": \"1323114847\"}, \"message\": \"Add a git log action.  Still needs tests.\"}",
    "phplib/Raggle/Scm.php",
    "phplib/Raggle/Scm/Git.php",
    "phplib/Raggle/Scm/Git/Action/Log.php",
    "phplib/Taggle/Document/Processor.php",
    "tests/phpunit/Raggle/Scm/GitTest.php",
    "",
    "{\"commit\": \"0ad16ab31834d2ba5f55a235db5741a53880eb2c\", \"author\": {\"name\": \"Laura Beth Lincoln\", \"email\": \"llincoln@etsy.com\", \"date\": \"1322859545\"}, \"committer\": {\"name\": \"Laura Beth Lincoln\", \"email\": \"llincoln@etsy.com\", \"date\": \"1322859545\"}, \"message\": \"Add functionality to get the head sha.\"}",
    "phplib/Raggle/Scm.php",
    "phplib/Raggle/Scm/Git.php",
    "phplib/Raggle/Scm/Git/Action/GetHeadSha.php",
    "phplib/Raggle/Scm/Git/Factory.php",
    "tests/phpunit/Raggle/Scm/Git/Action/CheckoutTest.php",
    "tests/phpunit/Raggle/Scm/Git/Action/GetHeadShaTest.php",
    "tests/phpunit/Raggle/Scm/GitTest.php",
    "",
    "{'commit': '6db5fdb1487dd4da54b89da452133e3eb0029ff0', 'author': {'name': 'Laura Beth Lincoln', 'email': 'llincoln@etsy.com', 'date': '1322851830'}, 'committer': {'name': 'Laura Beth Lincoln', 'email': 'llincoln@etsy.com', 'date': '1322851830'}, 'message': 'Remove testing code from Factory.'}",
    "phplib/Raggle/Scm/Git/Action/Checkout.php",
    "phplib/Raggle/Scm/Git/Factory.php",
    "tests/phpunit/Raggle/Scm/Git/Action/CheckoutTest.php",
);*/

