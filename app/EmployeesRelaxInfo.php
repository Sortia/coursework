<?php

namespace coursework\app;

require_once "EmployeesInfo.php";
require_once "EmployeesWorkInfo.php";
require_once "Database.php";

class EmployeesRelaxInfo extends EmployeesWorkInfo
{
    private $table = 'relax';

    protected $relax_with;
    protected $relax_by;
    protected $relax_type;
    protected $employee_id;

    protected static $days_in_month;

    public function Input()
    {
        self::$db->create($this->getClassVars(), $this->table);
    }

    public static function Output($request)
    {
        self::initDatabase();
        self::$days_in_month = cal_days_in_month(CAL_GREGORIAN, $request['month'], $request['year']);

        $all = self::$db->query("SELECT employees.id, employees.fio, employees.position, employees.salary, 
            employees.experience, employees.work_start_date, employees_relax.relax_with, employees_relax.relax_by, employees_relax.relax_type 
            FROM employees LEFT JOIN employees_relax ON employees.id = employees_relax.employee_id;");

        $all = combine_key_values($all, 'id', 'fio', 'position', 'salary', 'experience', 'work_start_date', 'relax_with', 'relax_by', 'relax_type');
        $all = self::prepareResponse($all, $request);

        return [$all, self::$days_in_month];
    }

    private static function prepareResponse($all, $request)
    {
        $result = [];

        foreach ($all as $row) {
            $result[$row['id']]['fio'] = $row['fio'];
            $result[$row['id']]['position'] = $row['position'];
            $result[$row['id']]['work_start_date'] = $row['work_start_date'];

            for ($i = 0; $i < self::$days_in_month; $i++) {
                $day = (mktime(0, 0, 0, $request['month'], $i, $request['year']));

                if ($day < strtotime($result[$row['id']]['work_start_date']))
                    $result[$row['id']]['days'][$i] = 'not_worked';
                elseif ($day >= strtotime($row['relax_with']) && $day <= strtotime($row['relax_by']))
                    $result[$row['id']]['days'][$i] = $row['relax_type'];
                elseif (!filled($result[$row['id']]['days'][$i]))
                    $result[$row['id']]['days'][$i] = '';

                if (in_array(date('N', $day), [6, 7]))
                    $result[$row['id']]['days'][$i] = 'holiday';
            }
        }

        $result = self::countingDays($result);
        $result = self::countingPay($result, $all);

        return $result;
    }

    protected function getClassVars()
    {
        return [
            'relax_with' => $this->relax_with,
            'relax_by' => $this->relax_by,
            'relax_type' => $this->relax_type,
            'employee_id' => $this->employee_id,
        ];
    }

    protected static function countingPay($result, $all)
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
                + (($person['salary'] * $sick_koef) / (self::$days_in_month - $result[$person['id']]['holidays']) * $result[$person['id']]['sick_days']);

            $result[$person['id']]['month_salary'] = round($result[$person['id']]['month_salary'], 2);
        }

        return $result;
    }

    protected static function countingDays($result)
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