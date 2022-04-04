<?php

class ByPassStatus extends Database
{
    public function getTable($id)
    {
        $query = "SELECT 
                  e.firstName, 
                  e.middleName, 
                  e.surName,
                  h.employeeId,
                  h.leaveType,
                  h.leaveDate,
                  h.leaveDateUntil,
                  h.leaveRemarks,
                  h.status,
                  h.type,
                  h.transpoAllowance
                  FROM hr_leave h
                  LEFT JOIN hr_employee e ON e.idNumber = h.employeeId 
                  WHERE leaveRemarks LIKE '%Bypass Leave:%'";

        if ($this->getPosition() != 'HR Staff' && $this->getPosition() != 'President') {
            $query .= " AND employeeId = '$id'";
        }

        $query .= " GROUP BY leaveId ASC";

        $sql = $this->connect()->query($query);
        $data = [];
        $totalData = 0;
        if ($sql->num_rows > 0) {
            while ($result = $sql->fetch_assoc()) {
                extract($result);

                $remarks = str_replace("Bypass Leave:", "", $leaveRemarks);

                $name = $firstName . " " . $middleName . " " . $surName;

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

                if ($status == 0) {
                    $statusOfHR = "Without Pay";
                } else {
                    $statusOfHR = "With Pay";
                }
            
            	if ($type == 0) {
                    $type = "Sick Leave";
                } else if ($type == 1) {
                    $type = "Vacation Leave";
                } else if ($type == 2) {
                    $type = "Bereavement Leave";
                } else if ($type == 3) {
                    $type = "Maternity Leave";
                } else if ($type == 4) {
                    $type = "Emergency Leave";
                }

                $data[] = [
                    $employeeId,
                    $name,
                    $leaveType,
                    date("F j, Y", strtotime($leaveDate)),
                    date("F j, Y", strtotime($leaveDateUntil)),
                    $remarks,
                    $statusOfHR,
                    $type,
                    $transpoAllowance
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
