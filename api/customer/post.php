<?php
include '../../vendor/autoload.php';
include '../HttpHeader.php';

use Service\CustomerService;

$service = new CustomerService();
$result = $service->Create();
