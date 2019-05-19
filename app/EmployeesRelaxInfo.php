<?php

namespace coursework\app;

require_once "EmployeesInfo.php";
require_once "EmployeesWorkInfo.php";
require_once "Database.php";

class EmployeesRelaxInfo extends EmployeesWorkInfo
{
    static private $table = 'relax';
    static private $fields = ['id', 'fio', 'position', 'salary', 'experience', 'work_start_date', 'relax_with', 'relax_by', 'relax_type'];

    protected $relax_with;
    protected $relax_by;
    protected $relax_type;
    protected $employee_id;

    protected static $days_in_month;

    public function input() // создание новой записи
    {
        self::$db->create($this->getClassVars(), self::$table);
    }

    public static function output($request) // получение данных
    {
        $report_month = $request['month'];
        $report_year = $request['year'];

        self::initDatabase();
        self::$days_in_month = cal_days_in_month(CAL_GREGORIAN, $report_month, $report_year);

        $relax_employees = self::$db->query("SELECT employees.id, employees.fio, employees.position, employees.salary, 
            employees.experience, employees.work_start_date, relax.relax_with, relax.relax_by, relax.relax_type 
            FROM employees LEFT JOIN relax ON employees.id = relax.employee_id ");

        $relax_employees = combine_key_values($relax_employees, self::$fields);
        $relax_employees = self::prepareResponse($relax_employees, $report_month, $report_year);

        return [$relax_employees, self::$days_in_month];
    }

    private static function prepareResponse($relax_employees, $report_month, $report_year) // подготовка данных для ответа
    {
        $result = [];

        foreach ($relax_employees as $row) {
            $id = $row['id'];
            $result[$id]['fio'] = $row['fio'];
            $result[$id]['position'] = $row['position'];
            $result[$id]['work_start_date'] = $row['work_start_date'];

            for ($i = 0; $i < self::$days_in_month; $i++) {
                $day = (mktime(0, 0, 0, $report_month, $i, $report_year));

                if (in_array(date('N', $day), [6, 7]))
                    $result[$id]['days'][$i] = 'holiday';
                elseif ($day < strtotime($result[$id]['work_start_date']))
                    $result[$id]['days'][$i] = 'not_worked';
                elseif ($day >= strtotime($row['relax_with']) && $day <= strtotime($row['relax_by']))
                    $result[$id]['days'][$i] = $row['relax_type'];
                elseif (!filled($result[$row['id']]['days'][$i]))
                    $result[$id]['days'][$i] = '';


            }
        }

        $result = self::countingDays($result);
        $result = self::calcPay($result, $relax_employees);

        return $result;
    }

    protected function getClassVars() // получение переменных класса
    {
        return [
            'relax_with' => $this->relax_with,
            'relax_by' => $this->relax_by,
            'relax_type' => $this->relax_type,
            'employee_id' => $this->employee_id,
        ];
    }

    protected static function calcPay($result, $all) // расчет зарплаты за месяц
    {
        foreach ($all as $person) {
            if ($person['experience'] < 3)
                $sick_koef = 0.5;
            elseif ($person['experience'] > 3 && $person['experience'] < 5)
                $sick_koef = 0.6;
            elseif ($person['experience'] >= 5 && $person['experience'] < 8)
                $sick_koef = 0.7;
            else $sick_koef = 1;

            $result[$person['id']]['month_salary']
                = ($person['salary']
                    * ($result[$person['id']]['work_days'] + $result[$person['id']]['vacation_days'])
                    / (self::$days_in_month - $result[$person['id']]['holidays']))
                + (($person['salary'] * $sick_koef)
                    / (self::$days_in_month - $result[$person['id']]['holidays']) * $result[$person['id']]['sick_days']);

            $result[$person['id']]['month_salary'] = round($result[$person['id']]['month_salary'], 2);
        }

        return $result;
    }

    protected static function countingDays($result) // подсчет количества дней
    {
        foreach ($result as &$employee) {

            $employee['sick_days'] = $employee['not_worked'] = $employee['vacation_days'] = $employee['vacExp_days'] = $employee['holidays'] = 0;

            foreach ($employee['days'] as $day) {
                switch ($day) {
                    case 'sick':
                        $employee['sick_days']++;
                        break;
                    case 'vacation':
                        $employee['vacation_days']++;
                        break;
                    case 'vacExp':
                        $employee['vacExp_days']++;
                        break;
                    case 'holiday':
                        $employee['holidays']++;
                        break;
                    case 'not_worked':
                        $employee['not_worked']++;
                }
            }

            $employee['work_days']
                = self::$days_in_month
                - $employee['sick_days']
                - $employee['vacation_days']
                - $employee['vacExp_days']
                - $employee['holidays']
                - $employee['not_worked'];
        }

        return $result;
    }

    public function __construct($request)
    {
        parent::__construct($request);
    }

}