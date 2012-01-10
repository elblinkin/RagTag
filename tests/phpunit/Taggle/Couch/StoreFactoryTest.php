<?php

namespace Taggle\Couch;

require_once 'Autoload.php';

class StoreFactoryTest extends \PHPUnit_Framework_TestCase {

    function testCreate() {
        $factory = new StoreFactory();
        $this->assertInstanceOf('Taggle\Couch\Store', $factory->create());
    }
}