<?php

class Notifications extends Database
{
    public function getTable($userID)
    {
        $query = "SELECT 
                n.notificationId, 
                d.notificationDetail, 
                d.notificationKey, 
                l.dateIssued, 
                l.employeeNumber, 
                l.employeeName, 
                l.designation,
                l.department, 
                l.purposeOfLeave, 
                l.leaveFrom, 
                l.leaveTo, 
                l.listId
                FROM `system_notification` n 
                JOIN system_notificationdetails d ON n.notificationId = d.notificationId
                JOIN system_leaveform l ON d.notificationKey = l.listId
                WHERE n.notificationTarget = '$userID' AND l.status = 0";

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
                    '<button type="button" class="btn btn-warning employees" data-bs-toggle="modal" data-bs-target="#viewModal" id="' . $listId . '"
                    data-employee=\'{"employeeNumber":"' . $employeeNumber . '","employeeName":"' . $employeeName . '","designation":"' . $designation . '",
                    "department":"' . $department . '","purposeOfLeave":"' . $purposeOfLeave . '","leaveFrom":"' . date("F j, Y", strtotime($leaveFrom)) . '",
                    "leaveTo":"' . date("F j, Y", strtotime($leaveTo)) . '", "listId":"' . $listId . '"}\'>
  						View
					</button>',
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

    public function getHRTable()
    {
        $query = "SELECT 
                n.notificationId, 
                d.notificationDetail, 
                d.notificationKey, 
                l.dateIssued, 
                l.employeeNumber, 
                l.employeeName, 
                l.designation,
                l.department, 
                l.purposeOfLeave, 
                l.leaveFrom, 
                l.leaveTo, 
                l.listId, 
                l.reasonOfSuperior, 
                l.date
                FROM `system_notification` n 
                JOIN system_notificationdetails d ON n.notificationId = d.notificationId
                JOIN system_leaveform l ON d.notificationKey = l.listId
                WHERE l.status = 2
                GROUP BY l.employeeNumber";

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
                    '<button type="button" class="btn btn-warning hr" data-bs-toggle="modal" data-bs-target="#viewHRModal" id="' . $listId . '"
                    data-employee=\'{"employeeNumber":"' . $employeeNumber . '","employeeName":"' . $employeeName . '","designation":"' . $designation . '",
                    "department":"' . $department . '","purposeOfLeave":"' . $purposeOfLeave . '","leaveFrom":"' . date("F j, Y", strtotime($leaveFrom)) . '",
                    "leaveTo":"' . date("F j, Y", strtotime($leaveTo)) . '", "listId":"' . $listId . '", "reasonOfSuperior":"' . $reasonOfSuperior . '",
                    "date":"' . date("F j, Y", strtotime($date)) . '"}\'>
  						View
					</button>',
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

    public function getPosition($idNumber)
    {
        $sql = "SELECT p.positionName FROM hr_employee e 
                LEFT JOIN hr_positions p ON e.position = p.positionId 
                WHERE e.idNumber = '$idNumber'";
        $query = $this->connect()->query($sql);

        $result = $query->fetch_assoc();
        $pos = $result['positionName'];

        return $pos;
    }

    public function countNotification($position = '')
    {
        $HRId = $this->getHRId();
        $sql = '';

        if ($position == 'HR') {
            $sql .= "SELECT COUNT(listId) AS notifCount 
                    FROM system_notification 
                    WHERE notificationTarget = '$HRId' AND notificationStatus = 0";
        } else {
            $sql .= "SELECT COUNT(l.listId) AS notifCount 
                    FROM system_leaveform l 
                    LEFT JOIN system_notificationdetails n ON n.notificationKey = l.listId 
                    LEFT JOIN system_notification s ON s.notificationId = n.notificationId 
                    WHERE s.notificationTarget = '" . $_SESSION['userID'] . "' AND l.status = '0' 
                    GROUP BY l.department";
        }

        $query = $this->connect()->query($sql);

        $data = '';

        if ($query->num_rows > 0) {
            while ($result = $query->fetch_assoc()) {
                $data = $result['notifCount'];
            }
        } else {
            $data = 0;
        }

        return $data;
    }

    public function leaveFormApproval($id, $status, $remarks)
    {
        $sql = '';
        $data = '';
        if ($status == "disapprove") {
            $sql .= "UPDATE system_leaveform SET status = 4, reasonOfSuperior = '$remarks', date = NOW() WHERE listId = '$id'";
        } else if ($status == "approve") {
            $sql .= "UPDATE system_leaveform SET status = 2, reasonOfSuperior = '$remarks', date = NOW() WHERE listId = '$id'";
        }

        $query = $this->connect()->query($sql);

        if ($query) {
            if ($this->updateNotification($id)) {
                if ($status == "approve") {
                    if ($this->insertHRNotification()) {
                        $keys = $this->lastNotificationId();
                        if ($this->insertSystemNotificationHR($keys)) {
                            $data = "1";
                        } else {
                            $data = "2";
                        }
                    } else {
                        $data = "2";
                    }
                } else {
                    $data = "1";
                }
            } else {
                $data = "2";
            }
        } else {
            $data = "2";
        }

        return $data;
    }

    private function insertHRNotification()
    {
        $leaveId = $this->leaveFormId();

        $link = "/V4/11-3 Employee Leave/controllers/ck_newNotificationController.php?leaveFormId=" . $leaveId;

        $sql = "INSERT INTO system_notificationdetails 
                (notificationDetail, notificationKey, notificationLink, notificationType)
                VALUES('You have a leave application waiting for approval', '$leaveId', '$link', '38')";
        $query = $this->connect()->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    private function leaveFormId()
    {
        $sql = "SELECT 
                listId 
                FROM system_leaveform 
                ORDER BY listId DESC 
                LIMIT 1";
        $query = $this->connect()->query($sql);

        if ($result = $query->fetch_assoc()) {
            $id = $result['listId'];
        }

        return $id;
    }

    private function insertSystemNotificationHR($key)
    {
        $targetId = $this->getHRId();

        $sql = "INSERT INTO system_notification
                (notificationId, notificationTarget, targetType)
                VALUES('$key', '$targetId', '2')";
        $query = $this->connect()->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    private function lastNotificationId()
    {
        $sql = "SELECT 
                notificationId 
                FROM system_notificationdetails 
                ORDER BY notificationId DESC 
                LIMIT 1";
        $query = $this->connect()->query($sql);

        if ($result = $query->fetch_assoc()) {
            $id = $result['notificationId'];
        }

        return $id;
    }

    private function getHRId()
    {
        $sql = "SELECT 
                e.idNumber 
                FROM hr_employee e
                LEFT JOIN hr_positions p ON e.position = p.positionId
                WHERE p.positionName = 'HR Staff'";
        $query = $this->connect()->query($sql);

        if ($result = $query->fetch_assoc()) {
            $id = $result['idNumber'];
        }

        return $id;
    }

    private function updateNotification($id)
    {
        $sql = "UPDATE system_notification s
                LEFT JOIN system_notificationdetails n ON s.notificationId = n.notificationId
                SET s.notificationStatus = 1 
                WHERE n.notificationKey = '$id'";
        $query = $this->connect()->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    private function insertToHR($id, $leaveType, $from, $to, $remarks, $status, $type, $allowance, $flag)
    {
        $sql = "INSERT INTO hr_leave 
                (employeeId, leaveType, leaveDate, leaveDateUntil, leaveRemarks, status, type, transpoAllowance, quarantineFlag)
                VALUES ('$id', '$leaveType', '$from', '$to', '$remarks', '$status', '$type', '$allowance', '$flag')";
        $query = $this->connect()->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    private function updateLeaveForm($decision, $id)
    {
        $sql = "UPDATE system_leaveform
                SET status = '$decision'
                WHERE employeeNumber = '$id'";
        $query = $this->connect()->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    private function getLeaveDates()
    {
        $sql = "SELECT 
                leaveFrom, 
                leaveTo 
                FROM system_leaveform 
                ORDER BY listId DESC 
                LIMIT 1";
        $query = $this->connect()->query($sql);

        $data = array();

        while ($result = $query->fetch_assoc()) {
            $data[] = $result;
        }

        return $data;
    }

    public function updateHR($decision, $leaveType, $leaveRemarks, $status, $type, $transpoAllowance, $quarantine, $empId)
    {
        $newKey = $this->leaveFormId();

        $data = $this->getLeaveDates();

        $from = $data[0]['leaveFrom'];
        $to = $data[0]['leaveTo'];

        if ($this->updateLeaveForm($decision, $empId)) {
            if ($decision == 3) {
                if ($this->insertToHR($empId, $leaveType, $from, $to, $leaveRemarks, $status, $type, $transpoAllowance, $quarantine)) {
                    if ($this->updateNotification($newKey)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                if ($this->updateNotification($newKey)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function getNotificationType()
    {
        $sql = "SELECT 
        notificationName, 
        COUNT(notificationId) AS typeCount
        FROM system_notificationdetails
        LEFT JOIN system_notificationtype ON listId = notificationType
        GROUP BY notificationName";
        $query = $this->connect()->query($sql);

        return $query;
    }
}
