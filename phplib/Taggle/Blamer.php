<?php

interface Taggle_Blamer {

    function getBlame(
        $filename,
        $start_line,
        $end_line = null
    );
}