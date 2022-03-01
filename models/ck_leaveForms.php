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

    // Blue and Green Position Array
    private $bluePositions = array(
        "Deputy Factory Manager/PCO", "Factory Manager",
        "President"
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

    public function getSunday()
    {
        $year = date("Y");
        $dateStart = new DateTime($year . "-01-01");
        $dateEnd = new DateTime($year . "-12-31");
        $Sunday = array();

        while ($dateStart <= $dateEnd) {
            if ($dateStart->format("l") == "Sunday") {
                $Sunday[] = array(
                    "SundayDate" => $dateStart->format("Y-m-d")
                );
            }
            $dateStart->modify("+1 day");
        }

        return $Sunday;
    }

    public function getAllLeaveById($id)
    {
        $sql = "SELECT 
                leaveFrom,
                leaveTo
                FROM system_leaveform
                WHERE employeeNumber = '$id' AND status < 4";
        $result = $this->connect()->query($sql);
        $leaves = array();

        while ($row = $result->fetch_assoc()) {
            $leaves[] = $row;
        }

        return $leaves;
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

    // Check if position is inside array
    private function checkString($position)
    {
        if (in_array($position, $this->orangePositions)) {
            return true;
        } else {
            return false;
        }
    }

    // Check if position is a blue position

    private function checkBluePosition($position)
    {
        if (in_array($position, $this->bluePositions)) {
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
    public function getPosition($id)
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
        $link = "/V4/14-13 Notification Software/ck_viewNotification.php?leaveFormId=" . $lastID;
        $info = '';
        $sql = "INSERT INTO system_notificationdetails (notificationDetail, notificationKey, notificationLink, notificationType)
        VALUES ('You have a leave application waiting for approval', '$lastID', '$link', '38')";
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
                        LIKE '%factory%' OR p.positionName LIKE '%president%'
                        AND t.status = 1";
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
            } else if ($this->checkBluePosition($pos)) {

                // If blue and green positions request a leave, run this query

                $bluePos = "SELECT 
                        t.idNumber, 
                        t.firstName, 
                        p.positionName 
                        FROM hr_employee t 
                        LEFT JOIN hr_positions p ON t.position = p.positionId 
                        WHERE p.positionName 
                        LIKE '%president%'
                        AND t.status = 1";
                $blueQuery = $this->connect()->query($bluePos);

                while ($blueRow = $blueQuery->fetch_assoc()) {
                    $blueId = $blueRow['idNumber'];
                    $insertBlue = "INSERT INTO system_notification 
                    (notificationId, notificationTarget, notificationStatus, targetType)
                    VALUES ('$last_id', '$blueId', '0', '2')";
                    $blueResult = $this->connect()->query($insertBlue);

                    if ($blueResult) {
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
                        AND NOT p.positionName LIKE '%factory%'
                        AND t.status = 1";
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
                        LIKE '%factory%' OR p.positionName LIKE '%president%'
                        AND t.status = 1";
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
    private function validateLeave($id, $from, $to)
    {
        $sql = "SELECT * 
        		FROM system_leaveform 
                WHERE employeeNumber = '$id' 
                AND (leaveFrom BETWEEN '$from' AND '$to' 
                OR leaveTo BETWEEN '$from' AND '$to')
                AND status < 4";
        $result = $this->connect()->query($sql);

        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function insertToDB($id, $fullName, $positionName, $departmentName, $purpose, $from, $to)
    {
        $sql = "INSERT INTO system_leaveform 
        (dateIssued, employeeNumber, employeeName, designation, department, purposeOfLeave, leaveFrom, leaveTo, status)
        VALUES (NOW(), '$id', '$fullName', '$positionName', '$departmentName', '$purpose', '$from', '$to', '0')";
        $result = $this->connect()->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // Insert Leave inside Database
    public function insertLeave($id, $from, $to, $purpose)
    {
        $users = $this->getUser($id);

        foreach ($users as $key => $user) {
            $userId = $user['idNumber'];
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

        $validate = $this->validateLeave($userId, $from, $to);

        if ($validate == false) {
            echo "3";
            exit();
        }

        if ($this->insertToDB($id, $fullName, $positionName, $departmentName, $purpose, $from, $to)) {

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

    public function byPassInsert($data = array())
    {
        $status = $data['status'];
        $leaveType = $data['leaveType'];
        $type = $data['type'];
        $transpo = $data['transpo'];
        $quarantine = $data['quarantine'];
        $purpose = $data['purpose'];

        $sql = '';

        for ($i = 0; $i < count($data['employees']); $i++) {
            $employees = $data['employees'][$i];

            for ($j = 0; $j < count($data['dates']); $j++) {
                $dates = $data['dates'][$j];

                $sql = "INSERT INTO hr_leave
                (employeeId, leaveType, leaveDate, leaveDateUntil, leaveRemarks, status, type, transpoAllowance, quarantineFlag)
                VALUES ('$employees', '$leaveType', '$dates', '$dates', '$purpose', '$status', '$type', '$transpo', '$quarantine')";

                $result = $this->connect()->query($sql);
            }
        }

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
