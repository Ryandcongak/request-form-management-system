<?php
use function PHPSTORM_META\map;
session_start();
if (!isset($_SESSION['level'])) {
  header('location: ../index.php');
  exit;
}
if($_SESSION['level'] != "it")
{
    header('location: ../index.php');
    exit;
}
    // fungsi header dengan mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
     
    // membuat nama file ekspor "export-to-excel.xls"
    header("Content-Disposition: attachment; filename=Data-Request.xls");

require "../function.php";
$sql = query("SELECT u.depart, i.id,i.requestors_name, i.today_date, i.date_needed,i.requests_choose, i.notes_sharing,i.notes_others,i.director, i.it_team, i.status, i.done_by FROM users AS u INNER JOIN tb_requests AS i ON u.id = i.id_users ORDER BY i.today_date DESC");
?>

<table>
    <thead>
        <tr>
            <th>No. ID Request</th>
            <th>Requestor Name</th>
            <th>Departement</th>
            <th>Date Request</th>
            <th>Date Needed</th>
            <th>Type Request</th>
            <th>Note Sharing</th>
            <th>Others Note</th>
            <th>Status Request</th>
        </tr>
    </thead>
    <tbody>
        <?php        
        foreach($sql as $data):
        ?>
        <tr>
            <td><?= $data['id']; ?></td>
            <td><?= $data['requestors_name']; ?></td>
            <td><?= $data['depart']; ?></td>
            <td><?= $data['today_date']; ?></td>
            <td><?= $data['date_needed']; ?></td>
            <td><?= $data['requests_choose']; ?></td>
            <td><?= $data['notes_sharing']; ?></td>
            <td><?= $data['notes_others']; ?></td>
            <td><?php echo ($data['status']=='0')?"In Proses":"DONE by"; echo $data['done_by']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>