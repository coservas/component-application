<?php

$security = require 'packages/security.php';
$doctrine = require 'packages/doctrine.php';

return array_merge(
    $security,
    $doctrine,
);
