<?php

namespace Taggle\Couch;

class StoreFactory implements \Taggle\StoreFactory {

    function create() {
        $couch = new \CouchdbClient("http://localhost:5984", false, "taggle");
        $store = new Store($couch);
        return $store;
    }
}
