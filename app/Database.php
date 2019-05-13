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

        $query = "INSERT INTO " . $table . " (" . $keys_query . ") VALUES ('" . $values_query . "')";

        mysqli_query($this->link, $query);
    }

    public function read($what)
    {
        switch ($what) {
            default:
                $query = "SELECT * FROM employees";
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
        $query = "DELETE FROM employees WHERE id = $id";
        mysqli_query($this->link, $query);
    }

    public function query($query)
    {
        return mysqli_fetch_all(mysqli_query($this->link, $query));
    }

    private function fetch($database_result)
    {
        return !is_null($database_result) ? mysqli_fetch_all($database_result) : null;
    }
}