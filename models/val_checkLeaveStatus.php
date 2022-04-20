<?php

// Modified by CK

class LeaveStatus extends Database
{
    public function getTable($id)
    {

        $query = "SELECT
                DISTINCT(s.listId), 
                s.dateIssued, 
                s.employeeName, 
                s.purposeOfLeave, 
                s.leaveFrom, 
                s.leaveTo,
                s.documents,
                s.halfDayFlag,
                s.reasonOfLeader,
                s.dateApproveDenyByLeader,
                s.status, 
                s.reasonOfSuperior, 
                s.date, 
                s.hrRemarks, 
                h.leaveType,
                h.status AS hrStatus, 
                h.transpoAllowance 
                FROM system_leaveform s 
                LEFT JOIN hr_leave h ON h.listId = s.listId";

        if ($this->getPosition() != 'HR Staff' && $this->getPosition() != 'President') {
            $query .= " WHERE s.employeeNumber = '$id'";
        }

        // $query .= " GROUP BY h.leaveId";
        $query .= " ORDER BY FIELD(s.status, '0', '3', '2', '1', '4'), s.dateIssued DESC";

        $sql = $this->connect()->query($query);
        $data = [];
        $totalData = 0;
        if ($sql->num_rows > 0) {
            while ($result = $sql->fetch_assoc()) {
                extract($result);
                $transpo = "";
                $type = "";
                $half = "";

                $headApproval = false;

                if ($status == 0) {
                    $status = "For Leader/Superior Approval";
                } else if ($status == 1) {
                    $status = "Approved by Leader";
                } else if ($status == 2 && $reasonOfSuperior != "" && $headApproval == false) {
                    $status = "Approved By Superior";
                    $headApproval = true;
                } else if ($status == 4) {
                    $status = "Disapproved";
                } else if ($headApproval == true) {
                    $status = "For HR Approval";
                } else if ($status == 3) {
                    $status = "Approved";
                }

                if ($halfDayFlag == "0") {
                    $half = "Whole Day";
                } else if ($halfDayFlag == "1") {
                    $half = "Half Day";
                }


                if (!empty($leaveType) || $leaveType == 0.5 || $leaveType != NULL) {
                    $type = "Half Day";
                } else {
                    $type = "Whole Day";
                }


                if ($transpoAllowance == "1") {
                    $transpo = "Yes";
                } else {
                    $transpo = "No";
                }

                if ($hrStatus == 0) {
                    $statusOfHR = "Without Pay";
                } else {
                    $statusOfHR = "With Pay";
                }

                $buttonValue = "";
                if ($documents != "") {
                    //FURTHER EDITIFICATION----------------------------------------------------------------------------------VAL
                    $buttonValue = '<div class="btn-group">
                                		<a class="btn btn-info" target="_blank"href="' . $documents . '">View</a>
                            		</div>';
                }
                $data[] = [
                    date("F j, Y", strtotime($dateIssued)),
                    $employeeName,
                    ($this->getPosition() != 'HR Staff'  && $documents != "") ? $purposeOfLeave : $purposeOfLeave . ' ' . ' ' . " <a href='#uploadFileModal' class='btn btn-outline-primary btn-sm uploadFile' data-bs-toggle='modal'><i class='fa fa-upload'></i> Upload</a> <input type='hidden' class='listID' value='" . $listId . "'>",
                    date("F j, Y", strtotime($leaveFrom)),
                    date("F j, Y", strtotime($leaveTo)),
                    $buttonValue,
                    $half,
                    $reasonOfLeader,
                    ($dateApproveDenyByLeader == "0000-00-00" ? "" : date("F j, Y", strtotime($dateApproveDenyByLeader))),
                    $reasonOfSuperior,
                    ($date == "0000-00-00") ? "" : date("F j, Y", strtotime($date)),
                    $hrRemarks,
                    ($status == "Approved") ? $type : "",
                    ($status == "Approved") ? $statusOfHR : "",
                    ($status == "Approved") ? $transpo : "",
                    $status,
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

    private function getPosition()
    {
        $sql = "SELECT p.positionName FROM hr_employee e 
                LEFT JOIN hr_positions p ON e.position = p.positionId 
                WHERE e.idNumber = '" . $_SESSION['idNumber'] . "'";
        $query = $this->connect()->query($sql);

        $result = $query->fetch_assoc();
        $pos = $result['positionName'];

        return $pos;
    }
}
