<?php
/**
 * Created by PhpStorm.
 * User: Яяя
 * Date: 11.05.2019
 * Time: 16:43
 */

namespace coursework\app;

class EmployeesWorkInfo extends EmployeesInfo
{
    static private $table = 'employees';
    static private $fields = ['id', 'fio', 'birthday', 'address', 'phone', 'position', 'salary', 'experience', 'work_start_date'];

    protected $position;
    protected $salary;
    protected $experience;
    protected $work_start_date;

    public function input() // добавление сотрудника
    {
        self::$db->create($this->getClassVars(), self::$table);
    }

    public static function deleteEmp($id) // удаление сотрудника
    {
        self::initDatabase();
        self::$db->delete($id);
    }

    public static function output($request) // получение данных
    {
        self::initDatabase();

        $items = self::$db->read('all', self::$table);
        $items = combine_key_values($items, self::$fields);

        return $items;
    }

    protected function getClassVars() // получение переменных класса
    {
        return [
            'fio' => $this->fio,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'phone' => $this->phone,
            'position' => $this->position,
            'salary' => $this->salary,
            'experience' => $this->experience,
            'work_start_date' => $this->work_start_date,
        ];
    }

    public function __construct($request)
    {
        parent::__construct();

        foreach ($request as $key => $value)
            $this->$key = $value;
    }

}