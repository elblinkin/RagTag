<?php

namespace RagTag;

use RagTag\Printer\Console as ConsolePrinter;
use RagTag\Printer\File as FilePrinter;
use RagTag\Printer\Gearman as GearmanPrinter;

class LoggerFactory {

    function create(
        $console_log_file = null,
        /*GearmanJob*/ $job = null
    ) {
        $printers = array(new ConsolePrinter());
        if ($console_log_file != null) {
            $printers[] = new FilePrinter($console_log_file);
        }
        if ($job != null) {
            $printers[] = new GearmanPrinter($job);
        }
        return new Logger($printers);
    }
}