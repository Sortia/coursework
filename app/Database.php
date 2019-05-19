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
        $this->link = mysqli_connect($host, $user, $password, $database);
    }

    public function __destruct()
    {
        mysqli_close($this->link);
    }

    public function create($data, $table)
    {
        $keys = array_keys($data);
        $values = array_values($data);

        $keys_query = implode(', ', $keys);
        $values_query = implode('\', \'', $values);

        $query = "INSERT INTO $table ( $keys_query ) VALUES ('" . $values_query . "')";

        return mysqli_query($this->link, $query);
    }

    public function read($what, $table)
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

    public function delete($id)
    {
        $result = [];

        $result[] = mysqli_query($this->link, "DELETE FROM employees WHERE id = $id");
        $result[] = mysqli_query($this->link, "DELETE FROM relax WHERE employee_id = $id");

        return $result;
    }

    public function query($query)
    {
        $result = mysqli_query($this->link, $query);

        return $result ? mysqli_fetch_all($result) : [];
    }

    private function fetch($database_result)
    {
        return !is_null($database_result) ? mysqli_fetch_all($database_result) : null;
    }
}