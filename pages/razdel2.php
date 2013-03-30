<?require_once('../config.php');?><?require_once('../lib/geo.php');?><!DOCTYPE html>
<html>
<head>
    <title>���������� �������� ������� ���-������</title>
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
                        alert("Excel ���� ������");
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
                        alert("������ ������");
                    else
                        alert("������ �� ������");
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
                        alert("������ ������");
                    else
                        alert("������ �� ������");
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
                        alert("������ ������");
                    else
                        alert("������ �� ������"+data);
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

        <h2><img src="/images/xls.png">������� � Excel</h2>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(EXCEL_FINAL_FOLDER) ? '<span class="ok">' . EXCEL_FINAL_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right>������: � <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> ��
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            �����: <select name="city"><?=$city?></select> �����: <select name="area"><?=$area?></select>
            <input type="button" value="������������" class="inpbtn otchet"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/report.png">������ �������� ������</h2>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(REESTR_OBH_FOLDER) ? '<span class="ok">' . REESTR_OBH_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right>������: � <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> ��
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            �����: <select name="city"><?=$city?></select> �����: <select name="area"><?=$area?></select>
            <input type="button" value="������������" class="inpbtn reestr1"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/report.png">������ ������ ������������</h2>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(REESTR_SOGL_FOLDER) ? '<span class="ok">' . REESTR_SOGL_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right>������: � <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> ��
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            �����: <select name="city"><?=$city?></select> �����: <select name="area"><?=$area?></select>
            <input type="button" value="������������" class="inpbtn reestr2"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/report.png">������������� ������</h2>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(EMPTY_ADDRESS_FOLDER) ? '<span class="ok">' . EMPTY_ADDRESS_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right>������: � <input class="dt" name="dtB" onclick="this.value=''" type="text" value="01.01.2013"> ��
            <input class="dt"
                   name="dtE" onclick="this.value=''"
                   type="text"
                   value="31.01.2013">
            �����: <select name="city"><?=$city?></select> �����: <select name="area"><?=$area?></select>
            <input type="button" value="������������" class="inpbtn emptyaddr"></p>

    </div>

    <div class="descr">

        <h2><img src="/images/search.png">����� �� ����������</h2>

        <table>
            <tr>
                <td>������:</td>
                <td>� <input class="dt" name="dtB" onclick="this.value=''" type="text" value=""> ��
                    <input class="dt"
                           name="dtE" onclick="this.value=''"
                           type="text"
                           value=""></td>
            </tr>
            <tr>
                <td>�����:</td>
                <td><select name="city"><?=$city?></select></td>
            </tr>
            <tr>
                <td>�����:</td>
                <td><select name="area"><?=$area?></select></td>
            </tr>
            <tr>
                <td>��</td>
                <td><input class="pu" name="pu" type="text" value=""></td>
            </tr>
            <tr>
                <td>��</td>
                <td><input class="ls" name="ls" type="text" value=""></td>
            </tr>
            <tr>
                <td>�����</td>
                <td><input class="address" name="address" type="text" value=""></td>
            </tr>
        </table>

        <input type="button" value="�����" class="inpbtn search">

    </div>


    <!-- <h2><img src="/images/compare.png">�������� ��������� ���������</h2>

     <p>�������� ������ ��� �������:</p>
     <select>
         <option>1 ������� 2013</option>
         <option>2 ������� 2013</option>
         <option>3 ������� 2013</option>
         <option>4 ������� 2013</option>
     </select> <input type="button" id="btnSelRayon" value="�������� ���������" class="inpbtn inpgenerate"
                      src="/conv2excel.php">
 -->

</div>
<div class="modal"></div>
</body>
</html>
