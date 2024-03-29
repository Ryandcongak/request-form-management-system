<?php
require "../../function.php";
$id = $_GET['id'];
$datas = selectAllCustomQuery("SELECT * FROM tb_requests WHERE id = $id")[0];

?>
<div class="row">                    
    <div class="col-sm-6">
        <div class="mb-3">
            <label for="" class="form-label"><strong>Code Request</strong></label>
            <div id="test"><?php 
            $showcode=$datas['rq_code'];
            if($showcode=="")
            {
                echo "-";
            }
            else{
                echo $showcode;
            } ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label"><strong>Request Date</strong></label>
            <div id="test"><?= date("D, d F Y", strtotime($datas['today_date'])); ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label"><strong>Deadline</strong></label>
            <div id="test"><?= date("D, d F Y", strtotime($datas['date_needed'])); ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label"><strong>Requestor</strong></label>
            <div id="test"><?= $datas['requestors_name']; ?></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-3">
            <label for="" class="form-label"><strong>Category</strong></label>
            <div id="test">
            <?php 
                // kome to array
                $types = $datas['requests_choose'];
                $types_array = explode(',', $types);

                for($i = 0; $i < count($types_array); $i++){
                    ?>
                        <span style="text-transform: capitalize;" class='badge badge-primary'><?= $types_array[$i]; ?></span>
                    <?php
                }
            ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label"><strong>Approved Status</strong></label>
            <div id="test">
                <?php 
                    echo ($datas['director'] == 1) ? '<span class="mr-2 badge bg-success">Approved By Director</span>' : '<span class="mr-2 badge bg-warning">Pending By Director</span>';
                    echo ($datas['it_team'] == 1) ? '<span class="mr-2 badge bg-success">Approved By IT</span>' : '<span class="mr-2 badge bg-warning">Pending By IT</span>';
                ?>
            </div>
        </div>
        <?php
        $sNote = $datas['note'];
        $noteApproval = $datas['it_team'];
        if(empty($sNote) AND $noteApproval=="")
        {
            echo "";
        }
        elseif(!empty($sNote) AND $noteApproval==0){
            echo "<div class='mb-3'>
            <label for=' class='form-label'><strong>Note from IT</strong></label>
            <div id='test' class='card bg-warning text-white'><div class='card-body'> $sNote </div></div>
        </div>";
        }
        elseif(!empty($sNote) AND $noteApproval==1){
            echo "<div class='mb-3'>
            <label for=' class='form-label'><strong>Note from IT</strong></label>
            <div id='test' class='card bg-success text-white'><div class='card-body'> $sNote </div></div>
        </div>";
        }
        elseif(!empty($sNote) AND $noteApproval==2){
            echo "<div class='mb-3'>
            <label for=' class='form-label'><strong>Note from IT</strong></label>
            <div id='test' class='card bg-danger text-white'><div class='card-body'> $sNote </div></div>
        </div>";
        }
        ?>
    </div>
    <div class="col-sm-12">
        <div class="mb-3">
            <label for="" class="form-label"><strong>Content</strong></label>
            <div id="test"><?= $datas['notes_others']; ?></div>
        </div>
    </div>
</div>