<!DOCTYPE html>
<html>
    <body>

        <?
        try {
            $conn = mysql_connect('localhost', 'root', '') or die(mysql_errno() . mysql_error());
            $db = mysql_select_db('contoh') or die(mysql_errno() . mysql_error());
        } catch (Exception $e) {
            die($e->getTraceAsString());
        }
        ?>

        <?
        $jawaban = array('A', 'B', 'C', 'D', 'E');
        $data = array(
            array(
                'id_ujian' => 1,
                'id_soal' => 1,
                'soal' => 'Siapakah penemu Onta ?',
                'soal_jawaban' => array('John Travolta', 'Chuck Norris', 'Johnny Deep')
            ),
            array(
                'id_ujian' => 1,
                'id_soal' => 2,
                'soal' => '1 + 1 = ?',
                'soal_jawaban' => array('10', '12', '2')
            ),
            array(
                'id_ujian' => 1,
                'id_soal' => 3,
                'soal' => 'Negara ini ...',
                'soal_jawaban' => array('Korup', 'Gak korup', 'Gak korup')
            )
        );
        ?>

        <?
        $query = mysql_query("select * from tbl_jawaban where id_ujian = 1");
        $jawaban_dari_soal = array();
        if (mysql_num_rows($query) > 0) {
            while ($r = mysql_fetch_array($query)) {
                echo "Jawaban soal nomor {$r['id_soal']} adalah {$r['jawaban']}<br />";
                $jawaban_dari_soal[$r['id_soal']] = $r['jawaban'];
            }
        } else {
            $jawaban_dari_soal = null;
        }
        ?>
        <br />
        <div id="ujian-<?= $data[0]['id_ujian'] ?>">
            <? foreach ($data as $d) : ?>
                <div><?= $d['soal'] ?></div>
                <ul>
                    <? foreach ($d['soal_jawaban'] as $k => $j) : ?>
                        <li>
                            <input name="jawaban-<?= $d['id_soal'] ?>" 
                                   class="jawaban"
                                   type="radio" 
                                   value="<?= "{$d['id_ujian']}|{$d['id_soal']}|{$jawaban[$k]}" ?>"
                                   <?= isset($jawaban_dari_soal[$d['id_soal']]) && $jawaban_dari_soal[$d['id_soal']] == $jawaban[$k] ? "checked" : "" ?>
                                   />
                                   <?= $j ?>
                        </li>
                    <? endforeach ?>
                </ul>
            <? endforeach; ?>
        </div>
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script>
            $(function(){
                $('.jawaban').change(function(){
                    var dis = $(this)
                    , val = dis.val().split('|');
                    $.ajax({
                        url: 'action.php?id_ujian=' + val[0] + '&id_soal=' + val[1] + '&jawaban=' + val[2],
                        type: 'get',
                        dataType: 'json',
                        success: function(res) {
                            console.log(res);
                        }
                    })
                });
            });
        </script>
    </body>
</html>