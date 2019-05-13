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
    private $table = 'employees';

    protected $position;
    protected $salary;
    protected $experience;

    public function Input()
    {
        self::$db->create($this->getClassVars(), $this->table);
    }

    public static function deleteEmp($id)
    {
        self::initDatabase();
        self::$db->delete($id);
    }

    public static function Output($request)
    {
        self::initDatabase();

        $items = self::$db->read('all');
        $items = combine_key_values($items, 'id', 'fio', 'birthday', 'address', 'phone', 'position', 'salary', 'experience');

        return $items;
    }

    protected function getClassVars()
    {
        return [
            'fio' => $this->fio,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'phone' => $this->phone,
            'position' => $this->position,
            'salary' => $this->salary,
            'experience' => $this->experience,
        ];
    }

    public function __construct($request)
    {
        parent::__construct();

        foreach ($request as $key => $value)
            $this->$key = $value;
    }

}