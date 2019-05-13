<?php
/**
 * Created by PhpStorm.
 * User: Яяя
 * Date: 11.05.2019
 * Time: 16:42
 */

    require_once "main_script.php";
    require_once "layouts/app.php";
    require_once "layouts/modals.html";

?>

<div class="container mt-5">

    <div class="card shadow-lg">
        <div class="card-header">

            <span class="h5">Сотрудники</span>
            <div class="buttons float-right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addEmp">Добавить</button>
                <button id="del" class="btn btn-danger btn-sm">Удалить</button>
                <button id="send" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#goto">Действия</button>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-hover select-rows">
                <thead>
                <tr class="header">
                    <th scope="col">#</th>
                    <th scope="col">Ф.И.О.</th>
                    <th scope="col">День рождения</th>
                    <th scope="col">Адрес</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Должность</th>
                    <th scope="col">Зарплата</th>
                    <th scope="col">Стаж</th>
                </tr>
                </thead>
                <tbody>


                <?php

                $i = 1;


                /** @var array $employees_data */
                foreach ($employees_data as $employee) {

                    echo "<tr>
                                <input class='id' type='hidden' value='" . $employee['id'] . "'>
                                <th scope=\"row\">$i</th>
                                <td>" . $employee['fio'] . "</td>
                                <td>" . dateFormat($employee['birthday']) . "</td>
                                <td>" . $employee['address'] . "</td>
                                <td>" . $employee['phone'] . "</td>
                                <td>" . $employee['position'] . "</td>
                                <td>" . $employee['salary'] . "</td>
                                <td>" . $employee['experience'] . "</td>
                            </tr>";

                    $i++;
                }

                ?>

                </tbody>
            </table>

            <div class="sort-buttons text-center">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#getReportCard">Табель
                </button>
            </div>

        </div>
    </div>
</div>






