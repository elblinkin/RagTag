<?php

interface Raggle_Scm {

    function getName();
    
    function checkout($repo);
    
    function revision($repo);
    
    function log($repo, $start_rev, $end_rev);
}