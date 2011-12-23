<?php

namespace Raggle\Scm;

interface Repository {

    /**
     * Returns the name of the repository.
     *
     * @return the name of the respository.
     */
    function getName();
}