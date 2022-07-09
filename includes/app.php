<?php
require 'functions.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';
// CONNECT TO DB
use Model\activeRecord;
ActiveRecord::setDB($db);