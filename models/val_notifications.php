<?php

class Notifications extends Database
{
    public function getTable($userID)
    {

        $query = "SELECT n.notificationId, d.notificationDetail, d.notificationKey, 
                            l.dateIssued, l.employeeNumber, l.employeeName, l.designation,
                            l.department, l.purposeOfLeave, l.leaveFrom, l.leaveTo
                    FROM `system_notification` n 
                    JOIN system_notificationdetails d ON n.notificationId = d.notificationId
                    JOIN system_leaveform l ON n.listId = l.listId
                    WHERE n.`notificationTarget` = '$userID'";
        $sql = $this->connect()->query($query);
        $data = [];
        $totalData = 0;
        if ($sql->num_rows > 0) {
            while ($result = $sql->fetch_assoc()) {
                extract($result);

                $data[] = [
                    $notificationId,
                    $notificationDetail,
                    $notificationKey,
                    '<div class="btn-group">
                        <a class="btn btn-warning" href="val_editForm.php?userId=' . $listId . '">Edit</a>
                    </div>',
                ];
                $totalData++;
            }
        }
        $json_data = array(
            "draw"            => 1,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalData), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format
    }
}
