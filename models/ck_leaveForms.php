<?php

class LeaveForm extends Database
{
    // Orange Positions Array
    private $orangePositions = array(
        "Assistant Supervisor", "Supervisor",
        "Assistant Manager", "Manager",
        "Technical Development /IT Dept. Manager/ Safety Officer",
        "Manager / Safety Officer"
    );

    // Get Holiday
    public function holidays()
    {
        $sql = "SELECT * FROM hr_holiday";
        $result = $this->connect()->query($sql);
        $holidays = array();

        while ($row = $result->fetch_assoc()) {
            $holidays[] = $row;
        }

        return $holidays;
    }

    // Get All User
    public function getAllUser()
    {
        $sql = "SELECT * FROM hr_employee WHERE status = 1";
        $result = $this->connect()->query($sql);
        $users = array();

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    // If check if position is inside array
    private function checkString($position)
    {
        if (in_array($position, $this->orangePositions)) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by id
    public function getUser($id)
    {
        $sql = "SELECT * FROM hr_employee WHERE status = 1 and idNumber = '$id'";
        $result = $this->connect()->query($sql);
        $users = array();

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    // Get department by id
    private function getDepartment($id)
    {
        $sql = "SELECT * FROM hr_department WHERE departmentId = '$id'";
        $result = $this->connect()->query($sql);
        $department = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $department[] = $row;
            }
        }
        return $department;
    }

    // Get position by id
    private function getPosition($id)
    {
        $sql = "SELECT * FROM hr_positions WHERE positionId = '$id'";
        $result = $this->connect()->query($sql);
        $position = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $position[] = $row;
            }
        }
        return $position;
    }

    // Get the last ID of table system_leaveform
    private function leaveFormLastId()
    {
        $sql = "SELECT listId FROM system_leaveform ORDER BY listId DESC LIMIT 1";
        $result = $this->connect()->query($sql);

        if ($row = $result->fetch_assoc()) {
            $id = $row['listId'];
        }

        return $id;
    }

    // Get the last ID of table system_notificationdetails
    private function notificationLastID()
    {
        $sql = "SELECT notificationId FROM system_notificationdetails ORDER BY notificationId DESC LIMIT 1";
        $result = $this->connect()->query($sql);

        if ($row = $result->fetch_assoc()) {
            $id = $row['notificationId'];
        }

        return $id;
    }

    // Insert notifications
    private function insertNotification($pos, $dep = '', $lastID)
    {
        $info = '';
        $sql = "INSERT INTO system_notificationdetails (notificationDetail, notificationKey, notificationType)
        VALUES ('You have a leave application waiting for approval', '$lastID', '38')";
        $result = $this->connect()->query($sql);

        if ($result) {

            $last_id = $this->notificationLastID();

            // If orange positions request a leave, run this query

            if ($this->checkString($pos)) {
                $orangePos = "SELECT 
                        t.idNumber, 
                        t.firstName, 
                        p.positionName 
                        FROM hr_employee t 
                        LEFT JOIN hr_positions p ON t.position = p.positionId 
                        WHERE p.positionName 
                        LIKE '%factory%' OR p.positionName LIKE '%president%'";
                $orangeQuery = $this->connect()->query($orangePos);

                while ($orangeRow = $orangeQuery->fetch_assoc()) {
                    $orangeId = $orangeRow['idNumber'];
                    $insertOrange = "INSERT INTO system_notification 
                    (notificationId, notificationTarget, notificationStatus, targetType)
                    VALUES ('$last_id', '$orangeId', '0', '2')";
                    $orangeResult = $this->connect()->query($insertOrange);

                    if ($orangeResult) {
                        $info = "1";
                    } else {
                        $info = "2";
                    }
                }
            } else {

                // If yellow positions request a leave, run this query

                $yellowPos = "SELECT 
                        t.idNumber, 
                        t.firstName, 
                        p.positionName 
                        FROM hr_employee t 
                        LEFT JOIN hr_positions p ON t.position = p.positionId 
                        WHERE t.departmentId = '$dep' 
                        AND (p.positionName LIKE '%manager%' OR p.positionName LIKE '%supervisor%') 
                        AND NOT p.positionName LIKE '%factory%'";
                $yellowQuery = $this->connect()->query($yellowPos);

                // If there is an available manager from the department, run this query

                if ($yellowQuery->num_rows > 0) {
                    while ($yellowRow = $yellowQuery->fetch_assoc()) {
                        $yellowId = $yellowRow['idNumber'];
                        $insertYellow = "INSERT INTO system_notification 
                        (notificationId, notificationTarget, notificationStatus, targetType)
                        VALUES ('$last_id', '$yellowId', '0', '2')";
                        $yellowResult = $this->connect()->query($insertYellow);

                        if ($yellowResult) {
                            $info = "1";
                        } else {
                            $info = "2";
                        }
                    }
                } else {
                    // If there is no available manager from the department, run this query
                    $higherPos = "SELECT 
                        t.idNumber, 
                        t.firstName, 
                        p.positionName 
                        FROM hr_employee t 
                        LEFT JOIN hr_positions p ON t.position = p.positionId 
                        WHERE p.positionName 
                        LIKE '%factory%' OR p.positionName LIKE '%president%'";
                    $notifyHigherPos = $this->connect()->query($higherPos);

                    if ($notifyHigherPos) {
                        while ($notifyHigherRow = $notifyHigherPos->fetch_assoc()) {
                            $notifyHigherId = $notifyHigherRow['idNumber'];
                            $insertHigher = "INSERT INTO system_notification 
                            (notificationId, notificationTarget, notificationStatus, targetType)
                            VALUES ('$last_id', '$notifyHigherId', '0', '2')";
                            $higherResult = $this->connect()->query($insertHigher);

                            if ($higherResult) {
                                $info = "1";
                            } else {
                                $info = "2";
                            }
                        }
                    } else {
                        $info = "2";
                    }
                }
            }
        } else {
            $info = "2";
        }

        return $info;
    }

    // Insert Leave inside Database
    public function insertLeave($id, $from, $to, $purpose)
    {
        $users = $this->getUser($id);

        // Convert the signature base64 to image
        // $signature = base64_decode($signature);
        // $signature = imagecreatefromstring($signature);
        // $signature = imagejpeg($signature, 'assets/images/uploads/' . $id . '.jpg');

        // Move the signature to the assets folder
        // $signature = 'assets/images/uploads/' . $id . '.jpg';


        foreach ($users as $key => $user) {
            $userFirstName = $user['firstName'];
            $userSurName = $user['surName'];
            $userPosition = $user['position'];
            $userDept = $user['departmentId'];
        }

        $fullName = $userFirstName . " " . $userSurName;
        $department = $this->getDepartment($userDept);
        $position = $this->getPosition($userPosition);

        foreach ($department as $key => $dep) {
            $departmentId = $dep['departmentId'];
            $departmentName = $dep['departmentName'];
        }

        foreach ($position as $key => $pos) {
            $positionName = $pos['positionName'];
        }

        $sql = "INSERT INTO system_leaveform 
        (dateIssued, employeeNumber, employeeName, designation, department, purposeOfLeave, leaveFrom, leaveTo, status)
        VALUES (NOW(), '$id', '$fullName', '$positionName', '$departmentName', '$purpose', '$from', '$to', '0')";
        $result = $this->connect()->query($sql);

        if ($result) {

            $lastId = $this->leaveFormLastId();

            if ($this->insertNotification($positionName, $departmentId, $lastId) == "1") {
                echo "1";
            } else {
                echo "2";
                exit();
            }
        } else {
            echo "2";
            exit();
        }
    }
}
