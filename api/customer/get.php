<?php
include '../../vendor/autoload.php';
include '../HttpHeader.php';

use Service\CustomerService;

$service = new CustomerService();
$data = $service->Get();

echo json_encode($data);