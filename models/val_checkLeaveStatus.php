<?php

class LeaveStatus extends Database
{
    public function getTable($id)
    {
        $query = "SELECT * FROM system_leaveform WHERE employeeNumber = '$id'";
        $sql = $this->connect()->query($query);
        $data = [];
        $totalData = 0;
        if ($sql->num_rows > 0) {
            while ($result = $sql->fetch_assoc()) {
                extract($result);

                $data[] = [
                    $dateIssued,
                    $employeeNumber,
                    $employeeName,
                    $designation,
                    $department,
                    $purposeOfLeave,
                    $leaveFrom,
                    $leaveTo,
                    $status,
                    $reasonofSuperior,
                    $date,
                    $approvedDeniedBySuperior,
                    $approvedDeniedByLeader,
                    $dateApprevDenyByLeader,
                    $dateApproveDenyBySuperior,
                    $leaderApprovalFlag,
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
