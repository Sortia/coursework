<?php
/**
 * Created by PhpStorm.
 * User: Яяя
 * Date: 11.05.2019
 * Time: 17:03
 */

use coursework\app\EmployeesRelaxInfo;
use coursework\app\EmployeesWorkInfo;

require_once "app/EmployeesRelaxInfo.php";
require_once "app/EmployeesWorkInfo.php";
require_once "helpers.php";

if (empty($_REQUEST) && $_SERVER['REQUEST_URI'] === '/') {
    $employees_data = EmployeesWorkInfo::Output($_REQUEST);
}

if ($_SERVER['PHP_SELF'] === '/reportCard.php') {
    list($relax_data, $count_days) = EmployeesRelaxInfo::Output($_REQUEST);
}

if (isset($_REQUEST['del_id'])) {
    EmployeesWorkInfo::deleteEmp($_REQUEST['del_id']);
}

if (isset($_REQUEST['fio'])) { // сохранение
    $employee = new EmployeesWorkInfo($_REQUEST);
    $employee->Input();
}

if (isset($_REQUEST['relax_with']) && isset($_REQUEST['relax_by'])) { // сохранение
    $employee = new EmployeesRelaxInfo($_REQUEST);
    $employee->Input(1);
}
