<?php

class Couch_Store_Factory implements Store_Factory {

    function create() {
        $couch = new CouchdbClient("http://localhost:5984", false, "taggle");
        $store = new CouchStore($couch);
        return $store;
    }
}