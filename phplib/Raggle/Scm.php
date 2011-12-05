<?php

interface Raggle_Scm {

    function getName();
    
    function checkout($repo);
    
    function getRevision($repo);
    
    function getChangeLog($repo, $start_rev, $end_rev);
}