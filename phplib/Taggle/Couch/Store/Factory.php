<?php

class Taggle_Couch_Store_Factory implements Taggle_Store_Factory {

    function create() {
        $couch = new CouchdbClient("http://localhost:5984", false, "taggle");
        $store = new Taggle_Couch_Store($couch);
        return $store;
    }
}
