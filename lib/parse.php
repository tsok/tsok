<?

set_time_limit(0);
require_once('../config.php');
require_once('db.inc.php');
require_once('geo.php');
db_connect();

$csv_folder = CSV_FOLDER;

$cnt_rows = 0;

if ($handle = opendir($csv_folder)) {
    while (false !== ($file_name = readdir($handle))) {
        if ($file_name != "." && $file_name != "..") {

            $fname = explode('.', $file_name);
            $parts = explode('-', $fname[0]);

            if (count($parts) >= 2) {
                $parts_city = array_search($parts[0], $city_ar) !== FALSE ? array_search($parts[0], $city_ar) : 0;
                $parts_area = array_search($parts[1], $area_ar) !== FALSE ? array_search($parts[1], $area_ar) : 0;

                $_REQUEST['city'] = intval($_REQUEST['city']) ? intval($_REQUEST['city']) : $parts_city;
                $_REQUEST['area'] = intval($_REQUEST['area']) ? intval($_REQUEST['area']) : $parts_area;
            }

            if (($handle_f = fopen($csv_folder . $file_name, "r")) !== FALSE) {

                $first = false;


                $sql_begin = "insert into tsok_info (
                    kv ,
                    pu ,
                    ls ,
                    address,
                    city,
                    area,
                    face_type
                    ) values";

                $sql = array();

                $cnt = 0;

                while (($data_f = fgetcsv($handle_f, 1000, ";")) !== FALSE) {

                    $cnt++;
                    $cnt_rows++;

                    if ($first == false) {
                        $first = true;
                        continue;
                    }

                    $face_type = 0;

                    if (empty($data_f[1]))
                        $face_type = 1;
                    else if (empty($data_f[2]))
                        $face_type = 2;

                    $sql [] = "(
                    '" . addslashes($data_f[1]) . "',
                    '" . addslashes($data_f[2]) . "',
                    '" . addslashes($data_f[3]) . "',
                    '" . addslashes($data_f[10]) . "',
                    " . intval($_REQUEST['city']) . ",
                    " . intval($_REQUEST['area']) . ",
                    " . $face_type . "
                    )";

                    if ($cnt == MAX_INSERT_LIMIT) {
                        $sql_query = $sql_begin . implode($sql, ',');
                        db_query($sql_begin . implode($sql, ','));
                        $cnt = 0;
                        $sql = array();
                    }

                }

                if ($cnt != MAX_INSERT_LIMIT)
                    db_query($sql_begin . implode($sql, ','));

                fclose($handle_f);

            } else {
                $err = 1;
                //echo "�� ���������� ������� ����";
            }
        }
    }
    closedir($handle);
}

echo $cnt_rows;

?>