<?require_once('../config.php');?><?require_once('../lib/geo.php');?><!DOCTYPE html>
<html>
<head>
    <title>���������� �������� ������� ���-������</title>
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
                        alert("��������� �����: " + data);
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
                        alert("������� ������: " + data);
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
                        alert("��������� ��������� ���������: " + data);
                    else
                        alert(data);
                });
            })
        })
    </script>
</head>
<body>
<div class="action_area">
    <h2><img src="/images/import.png">������ ������ �� CSV-������</h2>

    <div class="descr">��� ���� ����� ������ � ������� ������ (������� �������� � Excel ������) ������ � ���� ������ ��
        ����� �������������.

        <p>������� ��������:</p>

        <ol>
            <li>��������� Excel � ������� CSV (C�������� ���->������ �������->CSV(����������� �������))</li>
            <li>����������� CSV ���� ����������� � ������� �����</li>
            <li>������ �� <b>�������������</b></li>
        </ol>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(CSV_FOLDER) ? '<span class="ok">' . CSV_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right>�����: <select name="city"><?=$city?></select> �����: <select name="area"><?=$area?></select>
            <input type="button" value="�������������" class="inpbtn inpimport"></p>

    </div>

    <h2><img src="/images/sheets.png">�������� �������� ������</h2>

    <div class="descr">�� ���� ����������� ������ ������ ��������� �������� �����:
        <ul>
            <li>�� ������� � �������</li>
            <li>������ � �������������� ������������ ���������</li>
        </ul>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(EMPTY_EXCEL_FOLDER) ? '<span class="ok">' . EMPTY_EXCEL_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right> �����: <select name="city"><?=$city?></select> �����: <select name="area"><?=$area?></select>
            <input type="checkbox" value="1" id="onlyEmpty"> <label for="onlyEmpty">������ �������������</label>
            <input type="button" id="btnSelRayon" value="������������" class="inpbtn inpgenerate">
        </p>

    </div>


    <h2><img src="/images/import2.png">�������� ����������� �������� ������</h2>

    <div class="descr">��� ���� ����� ����������� ��������� ��������� �� �������� ������ (Excel-������) ������ � ����
        ������ ��
        ����� ���������.

        <p>������� ��������:</p>

        <ol>
            <li>����������� ����������� Excel ����� � ������ �����</i></li>
            <li>������ �� <b>��������� ���������</b></li>
        </ol>

        <p class="cur_folder">������� ������� �����:
            <b><?echo is_dir(FILLED_EXCEL_FOLDER) ? '<span class="ok">' . FILLED_EXCEL_FOLDER . '</span>' : '<span class="warn">�� ����������</span>';?></b>
        </p>

        <p align=right><input type="button" value="��������� ���������" class="inpbtn inpread"></p>

    </div>

</div>
<div class="modal"></div>
</body>
</html>
