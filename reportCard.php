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

<div class="container-fluid mt-5">
    <div class="card shadow-lg">
        <div class="card-header">
            <span class="h5">Сотрудники</span>
        </div>
        <div class="card-body">

            <div style="overflow-x: scroll">
                <table class="table report_table" style="width: 2300px">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ф.И.О.</th>
                        <th scope="col">Должность</th>
                        <?php
                        /** @var int $count_days */
                        for ($i = 1; $i <= $count_days; $i++)
                            echo "<th scope=\"col\">$i</th>";
                        ?>
                        <th scope="col">Отработано</th>
                        <th scope="col">Отпуск</th>
                        <th scope="col">Больничный</th>
                        <th scope="col">За свой счет</th>
                        <th scope="col">Зарплата</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $num = 1;

                    /** @var array $relax_data */
                    foreach ($relax_data as $row_data) {
                        echo "<tr>";
                        echo "<td>" . $num++ . "</td>";
                        echo "<td>" . $row_data['fio'] . "</td>";
                        echo "<td>" . $row_data['position'] . "</td>";

                        for ($i = 0; $i < $count_days; $i++)
                            echo "<td class='day green {$row_data['days'][$i]}'></td>";

                        echo "<td>" . $row_data['work_days'] * 8 . "</td>";
                        echo "<td>" . $row_data['vacation_days'] * 8 . "</td>";
                        echo "<td>" . $row_data['sick_days'] * 8 . "</td>";
                        echo "<td>" . $row_data['vacExp_days'] * 8 . "</td>";
                        echo "<td>" . $row_data['month_salary'] . "</td>";
                        echo "</tr>";
                    }

                    ?>
                    </tbody>
                </table>
            </div>

            <div class="descriptions text-right mt-3 mr-3">
                <div class="btn not_worked border">Не работал</div>
                <div class="btn green">Рабочие</div>
                <div class="btn holiday">Выходные</div>
                <div class="btn vacation">Отпуск</div>
                <div class="btn vacExp">За свой счет</div>
                <div class="btn sick">Больничный</div>
            </div>

            <div class="sort-buttons text-center mt-3">
                <a href="/">
                    <button type="button" class="btn btn-info">Назад</button>
                </a>
            </div>

        </div>
    </div>