<?php

class DB extends SQLite3 {
    private $filename = "../db.sqlite";
    function __construct($flags = SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $encryptionKey = null) {
        parent::__construct($this->filename, $flags, $encryptionKey);
    }
}
