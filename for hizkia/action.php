<?

try {
    $conn = mysql_connect('localhost', 'root', '') or die(mysql_errno() . mysql_error());
    $db = mysql_select_db('contoh') or die(mysql_errno() . mysql_error());
} catch (Exception $e) {
    die($e->getTraceAsString());
}
?>

<?

if (is_array($_GET) && count($_GET) == 3) {
    try {
        extract($_GET);
        $is_inserted = mysql_num_rows(mysql_query("select * from tbl_jawaban where id_ujian = {$id_ujian} and id_soal = {$id_soal}"));
        if ($is_inserted == 0) {
            $query = mysql_query("insert into tbl_jawaban(id_ujian, id_soal, jawaban) values({$id_ujian}, {$id_soal}, '{$jawaban}')");
            if ($query) {
                echo json_encode(array('result' => true));
            } else {
                echo json_encode(array('result' => false));
            }
        } else {
            $query = mysql_query("update tbl_jawaban set jawaban = '{$jawaban}' where id_ujian = {$id_ujian} and id_soal = {$id_soal}");
            if ($query) {
                echo json_encode(array('result' => true));
            } else {
                echo json_encode(array('result' => false));
            }
        }
    } catch (Exception $e) {
        die($e->getTraceAsString());
    }
}
?>