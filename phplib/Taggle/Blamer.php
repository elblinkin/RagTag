<?php

namespace Taggle;

interface Blamer {

    function getBlame(
        $filename,
        $start_line,
        $end_line = null
    );
}