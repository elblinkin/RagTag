<?php

interface Taggle_Document_Processor {

    /**
     * @param string|array $input file or array to be processed into logs.
     * @param string [$ref_id] id to relate multiple logs with.
     */
    function process($input, $ref_id=null);
}