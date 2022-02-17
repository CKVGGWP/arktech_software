<?php

class LeaveStatus extends Database
{
    public function getTable($id)
    {
        $query = "SELECT 
                s.dateIssued, 
                s.employeeName, 
                s.purposeOfLeave, 
                s.leaveFrom, 
                s.leaveTo, 
                s.status, 
                s.reasonOfSuperior, 
                s.date, 
                h.leaveRemarks, 
                h.leaveType,
                h.status AS hrStatus, 
                h.transpoAllowance 
                FROM system_leaveform s 
                LEFT JOIN hr_leave h ON h.employeeId = s.employeeNumber";

        if ($this->getPosition() != 'HR Staff' && $this->getPosition() != 'President') {
            $query .= " WHERE employeeNumber = '$id'";
        }

        $query .= " GROUP BY h.leaveId";

        $sql = $this->connect()->query($query);
        $data = [];
        $totalData = 0;
        if ($sql->num_rows > 0) {
            while ($result = $sql->fetch_assoc()) {
                extract($result);

                $headApproval = false;

                if ($status == 0) {
                    $status = "For Head Approval";
                } else if ($status == 2 && $reasonOfSuperior != "" && $headApproval == false) {
                    $status = "Approved By Head";
                    $headApproval = true;
                } else if ($status == 4) {
                    $status = "Disapproved";
                } else if ($headApproval == true) {
                    $status = "For HR Approval";
                } else if ($status == 3) {
                    $status = "Approved";
                }


                if ($leaveType == "") {
                    $leaveType = "Whole Day";
                } else {
                    $leaveType = "Half Day";
                }


                if ($transpoAllowance == "1") {
                    $transpoAllowance = "Yes";
                } else {
                    $transpoAllowance = "No";
                }

                if ($hrStatus == 0) {
                    $statusOfHR = "Without Pay";
                } else {
                    $statusOfHR = "With Pay";
                }

                $data[] = [
                    date("F j, Y", strtotime($dateIssued)),
                    $employeeName,
                    $purposeOfLeave,
                    date("F j, Y", strtotime($leaveFrom)),
                    date("F j, Y", strtotime($leaveTo)),
                    $reasonOfSuperior,
                    ($date == "0000-00-00") ? "" : date("F j, Y", strtotime($date)),
                    $leaveRemarks,
                    ($status == "Approved") ? $leaveType : "",
                    ($status == "Approved") ? $statusOfHR : "",
                    ($status == "Approved") ? $transpoAllowance : "",
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
                WHERE e.idNumber = '" . $_SESSION['userID'] . "'";
        $query = $this->connect()->query($sql);

        $result = $query->fetch_assoc();
        $pos = $result['positionName'];

        return $pos;
    }
}
