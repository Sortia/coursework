<?php
/**
 * Created by PhpStorm.
 * User: Яяя
 * Date: 11.05.2019
 * Time: 19:18
 */

namespace coursework\app;


class Database
{
    protected $link;

    public function __construct($host, $user, $password, $database)
    {
        $this->link = mysqli_connect($host, $user, $password, $database); // открытие соединения с БД
    }

    public function __destruct()
    {
        mysqli_close($this->link); // закрытие соединения с БД
    }

    public function create($data, $table) // добавление данных ($data) в переданную таблицу (аргумент $table)
    {
        $keys = array_keys($data);
        $values = array_values($data);

        $keys_query = implode(', ', $keys);
        $values_query = implode('\', \'', $values);

        $query = "INSERT INTO $table ( $keys_query ) VALUES ('" . $values_query . "')";

        return mysqli_query($this->link, $query);
    }

    public function read($what, $table) // получение данных из таблицы $table
    {
        switch ($what) {
            default:
                $query = "SELECT * FROM $table";
                $data = mysqli_query($this->link, $query);
                break;
        }

        $result = $this->fetch($data);

        return $result;
    }

    public function update($id, $data)
    {

    }

    public function delete($id) // удаление данных
    {
        $result = [];

        $result[] = mysqli_query($this->link, "DELETE FROM employees WHERE id = $id");
        $result[] = mysqli_query($this->link, "DELETE FROM relax WHERE employee_id = $id");

        return $result;
    }

    public function query($query) // выполнение пользовательского запроса к БД
    {
        $result = mysqli_query($this->link, $query);

        return $result ? mysqli_fetch_all($result) : [];
    }

    private function fetch($database_result) // получение данных в читабельном виде
    {
        return !is_null($database_result) ? mysqli_fetch_all($database_result) : null;
    }
}