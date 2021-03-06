<?php
/**
 * Created by PhpStorm.
 * User: Яяя
 * Date: 11.05.2019
 * Time: 16:42
 */

namespace coursework\app;

abstract class EmployeesInfo
{
    public abstract function input();

    public static abstract function output($request);

    protected abstract function getClassVars();

    protected $fio;
    protected $birthday;
    protected $address;
    protected $phone;

    protected static $db;

    public static function initDatabase() // инициализация соединения с БД
    {
        self::$db = new Database("127.0.0.1", "root", "", "coursework");
    }

    public function __construct()
    {
        self::initDatabase();
    }

}