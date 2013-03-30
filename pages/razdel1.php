<?require_once('../config.php');?><?require_once('../lib/geo.php');?><!DOCTYPE html>
<html>
<head>
    <title>Управление лицевыми счетами ЦОК-Энерго</title>
    <link rel="STYLESHEET" href="/css/style.css" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script>
        $(function () {

            $(".inpimport").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/parse.php', {
                    'city':self.parent().find("select[name='city']").val(),
                    'area':self.parent().find("select[name='area']").val()
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Добавлено строк: " + data);
                    else
                        alert(data);
                });
            })

            $(".inpgenerate").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/conv2excel.php', {
                    'city':self.parent().find("select[name='city']").val(),
                    'area':self.parent().find("select[name='area']").val(),
                    'fempty':($("#onlyEmpty").is(":checked") === true ? 1 : 0)
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Создано файлов: " + data);
                    else
                        alert(data);
                });
            })

            $(".inpread").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/readcell.php', {
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Обновлено показаний счетчиков: " + data);
                    else
                        alert(data);
                });
            })
        })
    </script>
</head>
<body>
<div class="action_area">
    <h2><img src="/images/import.png">Импорт данных из CSV-файлов</h2>

    <div class="descr">Для того чтобы данные о лицевых счетах (которые хранятся в Excel файлах) попали в базу данных их
        нужно импортировать.

        <p>Порядок действий:</p>

        <ol>
            <li>Сохранить Excel в формате CSV (Cохранить как->Другие форматы->CSV(разделители запятые))</li>
            <li>Сохраненный CSV файл скопировать в рабочую папку</li>
            <li>Нажать на <b>Импортировать</b></li>
        </ol>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(CSV_FOLDER) ? '<span class="ok">' . CSV_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right>Город: <select name="city"><?=$city?></select> Район: <select name="area"><?=$area?></select>
            <input type="button" value="Импортировать" class="inpbtn inpimport"></p>

    </div>

    <h2><img src="/images/sheets.png">Создание обходных листов</h2>

    <div class="descr">На базе загруженных данных данных создаются обходные листы:
        <ul>
            <li>По городам и районам</li>
            <li>Только с незаполненными показателями счетчиков</li>
        </ul>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(EMPTY_EXCEL_FOLDER) ? '<span class="ok">' . EMPTY_EXCEL_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right> Город: <select name="city"><?=$city?></select> Район: <select name="area"><?=$area?></select>
            <input type="checkbox" value="1" id="onlyEmpty"> <label for="onlyEmpty">только незаполненные</label>
            <input type="button" id="btnSelRayon" value="Сформировать" class="inpbtn inpgenerate">
        </p>

    </div>


    <h2><img src="/images/import2.png">Загрузка заполненных обходных листов</h2>

    <div class="descr">Для того чтобы заполненные показания счетчиков из обходных листов (Excel-файлов) попали в базу
        данных их
        нужно загрузить.

        <p>Порядок действий:</p>

        <ol>
            <li>Скопировать заполненные Excel файлы в нужную папку</i></li>
            <li>Нажать на <b>Загрузить показания</b></li>
        </ol>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(FILLED_EXCEL_FOLDER) ? '<span class="ok">' . FILLED_EXCEL_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right><input type="button" value="Загрузить показания" class="inpbtn inpread"></p>

    </div>

</div>
<div class="modal"></div>
</body>
</html>
