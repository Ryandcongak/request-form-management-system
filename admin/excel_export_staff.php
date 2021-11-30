<?php
use function PHPSTORM_META\map;
session_start();
if (!isset($_SESSION['level'])) {
  header('location: ../index.php');
  exit;
}
if($_SESSION['level'] != "staff")
{
    header('location: ../index.php');
    exit;
}
    // fungsi header dengan mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
     
    // membuat nama file ekspor "export-to-excel.xls"
    header("Content-Disposition: attachment; filename=Data-Request.xls");

require "../function.php";
$id_author = $_SESSION['users_id'];
$sql = query("SELECT u.depart, i.id,i.rq_code, i.requestors_name, i.today_date, i.date_needed,i.requests_choose, i.notes_sharing,i.notes_others,i.director, i.it_team, i.status,i.note, i.done_by FROM users AS u INNER JOIN tb_requests AS i ON u.id = i.id_users WHERE i.id_users = $id_author ORDER BY i.today_date DESC");
?>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>ID request</th>
            <th>Requestor Name</th>
            <th>Departement</th>
            <th>Date Request</th>
            <th>Date Needed</th>
            <th>Type Request</th>
            <th>Note Sharing</th>
            <th>Others Note</th>
            <th>Status Request</th>
            <th>Note from IT</th>
        </tr>
    </thead>
    <tbody>
        <?php        
        foreach($sql as $data):
        ?>
        <?php
        $no =0;
        $no++; ?>
        <tr>
            <td><?= $no; ?></td>
            <td>
                <?php
                $rq_code = $data['rq_code'];
                if(empty($rq_code))
                {
                    echo "-";
                }else
                {
                    echo $rq_code;
                }
                ?>
            </td>
            <td><?= $data['requestors_name']; ?></td>
            <td><?= $data['depart']; ?></td>
            <td><?= date("D, d F Y", strtotime($data['today_date'])); ?></td>
            <td><?= date("D, d F Y", strtotime($data['date_needed'])); ?></td>
            <td><?= $data['requests_choose']; ?></td>
            <td><?= $data['notes_sharing']; ?></td>
            <td><?= $data['notes_others']; ?></td>
            <td>
                <?php
                    switch($data['status']){
                        case 0 :
                            ?>
                                <span class='badge badge-warning'>In Progress</span>
                            <?php
                        break;

                        case 1 :
                            ?>
                                <span class='badge badge-success'>Done</span>
                            <?php
                        break;

                        case 2 :
                            ?>
                                <span class='badge badge-danger'>Rejected</span>
                            <?php
                        break;
                    }
                ?>
            </td>
            <td>
                <?php
                $noteIT = $data['note'];
                if(empty($noteIT))
                {
                    echo "-";
                }else
                {
                    echo $noteIT;
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>