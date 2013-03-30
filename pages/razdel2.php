<?require_once('../config.php');?><?require_once('../lib/geo.php');?><!DOCTYPE html>
<html>
<head>
    <title>Управление лицевыми счетами ЦОК-Энерго</title>
    <link rel="STYLESHEET" href="/css/style.css" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script>
        $(function () {

            $(".otchet").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/otchet.php', {
                    'dtB':self.parent().find("input[name='dtB']").val(),
                    'dtE':self.parent().find("input[name='dtE']").val(),
                    'city':self.parent().find("select[name='city']").val(),
                    'area':self.parent().find("select[name='area']").val()
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Excel файл создан");
                    else
                        alert(data);
                });
            });


            $(".reestr1").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/reestr1.php', {
                    'dtB':self.parent().find("input[name='dtB']").val(),
                    'dtE':self.parent().find("input[name='dtE']").val(),
                    'city':self.parent().find("select[name='city']").val(),
                    'area':self.parent().find("select[name='area']").val()
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Реестр создан");
                    else
                        alert("Реестр не создан");
                });
            });

            $(".reestr2").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/reestr2.php', {
                    'dtB':self.parent().find("input[name='dtB']").val(),
                    'dtE':self.parent().find("input[name='dtE']").val(),
                    'city':self.parent().find("select[name='city']").val(),
                    'area':self.parent().find("select[name='area']").val()
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Реестр создан");
                    else
                        alert("Реестр не создан");
                });
            });

            $(".emptyaddr").click(function () {
                $(".modal").show();
                self = $(this);
                $.post('/lib/empty_address.php', {
                    'dtB':self.parent().find("input[name='dtB']").val(),
                    'dtE':self.parent().find("input[name='dtE']").val(),
                    'city':self.parent().find("select[name='city']").val(),
                    'area':self.parent().find("select[name='area']").val()
                }, function (data) {
                    $(".modal").hide();
                    if (parseInt(data, 10))
                        alert("Реестр создан");
                    else
                        alert("Реестр не создан"+data);
                });
            });

            $(".search").click(function (e) {
                window.open("/lib/search.php?city=" + $(this).parent().find("select[name='city']").val() + "&area=" + $(this).parent().find("select[name='area']").val() + "&dtB=" + $(this).parent().find("input[name='dtB']").val() + "&dtE=" + $(this).parent().find("input[name='dtE']").val() + "&pu=" + $(this).parent().find("input[name='pu']").val() + "&ls=" + $(this).parent().find("input[name='ls']").val() + "&address=" + $(this).parent().find("input[name='address']").val());
                e.preventDefault();
            });


        })
    </script>
</head>
<body>
<div class="action_area">

    <div class="descr">

        <h2><img src="/images/xls.png">Склейка в Excel</h2>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(EXCEL_FINAL_FOLDER) ? '<span class="ok">' . EXCEL_FINAL_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right>Период: с <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> по
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            Город: <select name="city"><?=$city?></select> Район: <select name="area"><?=$area?></select>
            <input type="button" value="Сформировать" class="inpbtn otchet"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/report.png">Реестр обходных листов</h2>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(REESTR_OBH_FOLDER) ? '<span class="ok">' . REESTR_OBH_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right>Период: с <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> по
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            Город: <select name="city"><?=$city?></select> Район: <select name="area"><?=$area?></select>
            <input type="button" value="Сформировать" class="inpbtn reestr1"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/report.png">Реестр листов согласования</h2>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(REESTR_SOGL_FOLDER) ? '<span class="ok">' . REESTR_SOGL_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right>Период: с <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> по
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            Город: <select name="city"><?=$city?></select> Район: <select name="area"><?=$area?></select>
            <input type="button" value="Сформировать" class="inpbtn reestr2"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/report.png">Незаполненные адреса</h2>

        <p class="cur_folder">Текущая рабочая папка:
            <b><?echo is_dir(EMPTY_ADDRESS_FOLDER) ? '<span class="ok">' . EMPTY_ADDRESS_FOLDER . '</span>' : '<span class="warn">Не определена</span>';?></b>
        </p>

        <p align=right>Период: с <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> по
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            Город: <select name="city"><?=$city?></select> Район: <select name="area"><?=$area?></select>
            <input type="button" value="Сформировать" class="inpbtn emptyaddr"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/search.png">Поиск по параметрам</h2>

        <table>
            <tr>
                <td>Период:</td>
                <td>с <input class="dt" name="dtB" onclick="this.value=''" type="text" value=""> по
                    <input class="dt"
                           name="dtE" onclick="this.value=''"
                           type="text"
                           value=""></td>
            </tr>
            <tr>
                <td>Город:</td>
                <td><select name="city"><?=$city?></select></td>
            </tr>
            <tr>
                <td>Район:</td>
                <td><select name="area"><?=$area?></select></td>
            </tr>
            <tr>
                <td>ПУ</td>
                <td><input class="pu" name="pu" type="text" value=""></td>
            </tr>
            <tr>
                <td>ЛС</td>
                <td><input class="ls" name="ls" type="text" value=""></td>
            </tr>
            <tr>
                <td>Адрес</td>
                <td><input class="address" name="address" type="text" value=""></td>
            </tr>
        </table>

        <input type="button" value="Найти" class="inpbtn search">

    </div>


    <!-- <h2><img src="/images/compare.png">Сравнить показания счетчиков</h2>

     <p>Выберите период для анализа:</p>
     <select>
         <option>1 квартал 2013</option>
         <option>2 квартал 2013</option>
         <option>3 квартал 2013</option>
         <option>4 квартал 2013</option>
     </select> <input type="button" id="btnSelRayon" value="Сравнить показания" class="inpbtn inpgenerate"
                      src="/conv2excel.php">
 -->

</div>
<div class="modal"></div>
</body>
</html>
