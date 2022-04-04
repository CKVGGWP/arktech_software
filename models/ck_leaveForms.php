<?php

class LeaveForm extends Database
{
    // Leader Array
    private $leaderPos = array(
        "Team Leader"
    );

    // Supervisor Array
    private $supervisorPos = array(
        "Assistant Supervisor", "Supervisor",
    );

    // Manager Array
    private $managerPos = array(
        "Assistant Manager", "Manager",
        "Technical Development /IT Dept. Manager/ Safety Officer",
        "Manager / Safety Officer"
    );

    // Factory Manager and President Array
    private $higherPos = array(
        "Deputy Factory Manager/PCO", "Factory Manager",
        "President"
    );

    private $leaderPosition = "Team Leader";
    private $supervisorPosition = "Supervisor";
    private $managerPosition = "manager";

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
    private function checkString($position, $array)
    {
        if (in_array($position, $array)) {
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

    private function getSection($id)
    {
        $sql = "SELECT * FROM ppic_section WHERE sectionId = '$id'";
        $result = $this->connect()->query($sql);
        $section = array();

        while ($row = $result->fetch_assoc()) {
            $section[] = $row;
        }

        return $section;
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

    private function selectPos($pos, $dept, $secId = '')
    {
        $sql = "";
        $sql .= "SELECT 
                t.idNumber, 
                t.firstName, 
                p.positionName 
                FROM hr_employee t 
                LEFT JOIN hr_positions p ON t.position = p.positionId 
                WHERE p.positionName LIKE '%$pos%'
                AND t.departmentId = '$dept'
                AND t.status = 1";
        if ($pos == "Team Leader") {
            $sql .= " AND t.sectionId = '$secId'";
        }
        $query = $this->connect()->query($sql);

        return $query;
    }

    private function selectManager($dept)
    {
        $sql = "SELECT 
                t.idNumber, 
                t.firstName, 
                p.positionName 
                FROM hr_employee t 
                LEFT JOIN hr_positions p ON t.position = p.positionId 
                WHERE t.departmentId = '$dept' 
                AND (p.positionName LIKE '%supervisor%' OR p.positionName LIKE '%manager%') 
                AND NOT p.positionName LIKE '%factory%'
                AND t.status = 1";
        $query = $this->connect()->query($sql);

        return $query;
    }

    private function selectFactoryManager()
    {
        $sql = "SELECT 
                t.idNumber, 
                t.firstName, 
                p.positionName 
                FROM hr_employee t 
                LEFT JOIN hr_positions p ON t.position = p.positionId 
                WHERE p.positionName 
                LIKE '%factory%'
                AND t.status = 1";
        $query = $this->connect()->query($sql);

        return $query;
    }

    private function selectPresident()
    {
        $sql = "SELECT 
                t.idNumber, 
                t.firstName, 
                p.positionName 
                FROM hr_employee t 
                LEFT JOIN hr_positions p ON t.position = p.positionId 
                WHERE p.positionName 
                LIKE '%president%'
                AND NOT p.positionName LIKE '%vice%'
                AND t.status = 1";
        $query = $this->connect()->query($sql);

        return $query;
    }

    private function notificationQuery($last_id, $id)
    {
        $sql = "INSERT INTO system_notification 
                (notificationId, notificationTarget, notificationStatus, targetType)
                VALUES ('$last_id', '$id', '0', '2')";
        $query = $this->connect()->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    // Insert notifications
    private function insertNotification($pos, $dep = '', $lastID, $sectionId)
    {
        $link = "/V4/14-13 Notification Software/ck_viewNotification.php?leaveFormId=" . $lastID;
        $info = '';
        $sql = "INSERT INTO system_notificationdetails (notificationDetail, notificationKey, notificationLink, notificationType)
        VALUES ('You have a leave application waiting for approval', '$lastID', '$link', '38')";
        $result = $this->connect()->query($sql);

        if ($result) {

            $last_id = $this->notificationLastID();

            // If the leader requests a leave, run this query

            if ($this->checkString($pos, $this->leaderPos)) {

                // If there is a supervisor, send notification to supervisor

                $supervisorResult = $this->selectManager($dep);

                if ($supervisorResult->num_rows > 0) {
                    while ($supervisorRow = $supervisorResult->fetch_assoc()) {
                        $supervisorId = $supervisorRow['idNumber'];
                        $insertSupervisor = $this->notificationQuery($last_id, $supervisorId);

                        if ($insertSupervisor) {
                            $info = "1";
                        } else {
                            $info = "2";
                        }
                    }
                } else {

                    // If there is no manager, send notification to factory manager

                    $factoryManagerResult = $this->selectFactoryManager();

                    if ($factoryManagerResult->num_rows > 0) {
                        while ($factoryManagerRow = $factoryManagerResult->fetch_assoc()) {
                            $factoryManagerId = $factoryManagerRow['idNumber'];
                            $insertFactoryManager = $this->notificationQuery($last_id, $factoryManagerId);

                            if ($insertFactoryManager) {
                                $info = "1";
                            } else {
                                $info = "2";
                            }
                        }
                    }
                }

                // If the supervisor requests a leave, run this query

            } else if ($this->checkString($pos, $this->supervisorPos)) {

                // If there is a manager, send notification to manager

                $managerResult = $this->selectManager($this->managerPosition, $dep);

                if ($managerResult->num_rows > 0) {
                    while ($managerRow = $managerResult->fetch_assoc()) {
                        $managerId = $managerRow['idNumber'];
                        $insertManager = $this->notificationQuery($last_id, $managerId);

                        if ($insertManager) {
                            $info = "1";
                        } else {
                            $info = "2";
                        }
                    }
                } else {

                    // If there is no manager, send notification to factory manager

                    $factoryManagerResult = $this->selectFactoryManager();

                    if ($factoryManagerResult->num_rows > 0) {
                        while ($factoryManagerRow = $factoryManagerResult->fetch_assoc()) {
                            $factoryManagerId = $factoryManagerRow['idNumber'];
                            $insertFactoryManager = $this->notificationQuery($last_id, $factoryManagerId);

                            if ($insertFactoryManager) {
                                $info = "1";
                            } else {
                                $info = "2";
                            }
                        }
                    }
                }

                // If the manager requests a leave, run this query

            } else if ($this->checkString($pos, $this->managerPos)) {

                // If there is a factory manager, send notification to factory manager

                $factoryManagerResult = $this->selectFactoryManager();

                if ($factoryManagerResult->num_rows > 0) {
                    while ($factoryManagerRow = $factoryManagerResult->fetch_assoc()) {
                        $factoryManagerId = $factoryManagerRow['idNumber'];
                        $insertFactoryManager = $this->notificationQuery($last_id, $factoryManagerId);

                        if ($insertFactoryManager) {
                            $info = "1";
                        } else {
                            $info = "2";
                        }
                    }
                } else {
                    // If there is no factory manager, send notification to president and 0422
                    $higherPosResult = $this->selectPresident();

                    if (
                        $higherPosResult->num_rows > 0
                    ) {
                        while ($higherPosRow = $higherPosResult->fetch_assoc()) {
                            $higherPosId = $higherPosRow['idNumber'];
                            $insertHigherPos = $this->notificationQuery($last_id, $higherPosId);
                            //-----------------Insert notification to user where ID = 0444------------------
                            if ($insertHigherPos) {
                                $info = "1";
                            } else {
                                $info = "2";
                            }
                        }
                    }
                    $insertHigherPos2 = $this->notificationQuery($last_id, '0422');
                }
            } else if ($this->checkString($pos, $this->higherPos)) {

                // If the factory manager or president requests a leave, run this query

                $higherPosResult = $this->selectPresident();

                if ($higherPosResult->num_rows > 0) {
                    while ($higherPosRow = $higherPosResult->fetch_assoc()) {
                        $higherPosId = $higherPosRow['idNumber'];
                        $insertHigherPos = $this->notificationQuery($last_id, $higherPosId);
                        //-----------------Insert notification to user where ID = 0444------------------
                        if ($insertHigherPos) {
                            $info = "1";
                        } else {
                            $info = "2";
                        }
                    }
                }
                $insertHigherPos2 = $this->notificationQuery($last_id, '0422');
            } else {
                // If employee requests a leave, run this query
                // If there is a leader, send notification to leader

                $leaderResult = $this->selectPos($this->leaderPosition, $dep, $sectionId);

                if ($leaderResult->num_rows > 0) {
                    while ($leaderRow = $leaderResult->fetch_assoc()) {
                        $leaderId = $leaderRow['idNumber'];
                        $insertLeader = $this->notificationQuery($last_id, $leaderId);

                        if ($insertLeader) {
                            $info = "1";
                        } else {
                            $info = "2";
                        }
                    }
                } else {

                    // If there is no leader, send notification to supervisor and manager

                    $supervisorResult = $this->selectManager($dep);

                    if ($supervisorResult->num_rows > 0) {
                        while ($supervisorRow = $supervisorResult->fetch_assoc()) {
                            $supervisorId = $supervisorRow['idNumber'];
                            $insertSupervisor = $this->notificationQuery($last_id, $supervisorId);

                            if ($insertSupervisor) {
                                $info = "1";
                            } else {
                                $info = "2";
                            }
                        }
                    } else {

                        // If there is no manager, send notification to factory manager

                        $factoryManagerResult = $this->selectFactoryManager();

                        if ($factoryManagerResult->num_rows > 0) {
                            while ($factoryManagerRow = $factoryManagerResult->fetch_assoc()) {
                                $factoryManagerId = $factoryManagerRow['idNumber'];
                                $insertFactoryManager = $this->notificationQuery($last_id, $factoryManagerId);

                                if ($insertFactoryManager) {
                                    $info = "1";
                                } else {
                                    $info = "2";
                                }
                            }
                        }
                    }
                }
            }

            return $info;
        }
    }

    // Insert Leave inside Database
    private function validateLeave($id, $from, $to)
    {
        $sql = "SELECT * 
        		FROM system_leaveform WHERE employeeNumber = '$id' 
                AND (leaveFrom <= '$from' AND leaveTo >= '$to') 
                AND NOT (leaveFrom > '$to' OR leaveTo < '$from') 
                AND status < 4";
        $result = $this->connect()->query($sql);

        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function insertToDB($id, $fullName, $positionName, $departmentName, $purpose, $from, $to, $fileName, $halfDay)
    {
        $sql = "INSERT INTO system_leaveform 
        (dateIssued, employeeNumber, employeeName, designation, department, purposeOfLeave, halfDayFlag, leaveFrom, leaveTo, status, documents)
        VALUES (NOW(), '$id', '$fullName', '$positionName', '$departmentName', '$purpose', '$halfDay', '$from', '$to', '0', '$fileName')";
        $result = $this->connect()->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // Insert Leave inside Database
    public function insertLeave($id, $from, $to, $purpose, $uploadFile, $halfDay)
    {
        $users = $this->getUser($id);

        foreach ($users as $key => $user) {
            $userId = $user['idNumber'];
            $userFirstName = $user['firstName'];
            $userSurName = $user['surName'];
            $userPosition = $user['position'];
            $userDept = $user['departmentId'];
            $userSection = $user['sectionId'];
        }

        $fullName = $userFirstName . " " . $userSurName;
        $department = $this->getDepartment($userDept);
        $position = $this->getPosition($userPosition);
        $section = $this->getSection($userSection);

        foreach ($department as $key => $dep) {
            $departmentId = $dep['departmentId'];
            $departmentName = $dep['departmentName'];
        }

        foreach ($position as $key => $pos) {
            $positionName = $pos['positionName'];
        }

        foreach ($section as $key => $sec) {
            $sectionId = $sec['sectionId'];
        }

        $validate = $this->validateLeave($userId, $from, $to);

        if ($validate == false) {
            echo "3";
            exit();
        }
        #Getting Manuscript Files
        $file = $_FILES['uploadFile'];
        $fileName = $_FILES['uploadFile']['name'];
        $fileTmpName = $_FILES['uploadFile']['tmp_name'];
        $fileSize = $_FILES['uploadFile']['size'];
        $fileError = $_FILES['uploadFile']['error'];
        $fileType = $_FILES['uploadFile']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('pdf', 'jpeg', 'jpg', 'png');

        date_default_timezone_set('Asia/Manila');

        $date = date('Y-m-d');

        if (!empty($fileName)) {
            $fileNameNew = str_replace("." . $fileActualExt, "", $fileName) . "_" . $date . "." . $fileActualExt;
            $fileLocation = "";
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 15000000) {
                        #Manuscript
                        $fileDestination = '../Leave Documents/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $fileLocation = "/V4/11-3 Employee Leave/Leave Documents/" . $fileNameNew;
                    } else {
                        echo "File is too big";
                        exit();
                    }
                } else {
                    echo "File error uploading";
                    exit();
                }
            } else {
                echo "File type not supported";
                exit();
            }
        }

        if ($this->insertToDB($id, $fullName, $positionName, $departmentName, $purpose, $from, $to, $fileLocation, $halfDay)) {

            $lastId = $this->leaveFormLastId();

            if ($this->insertNotification($positionName, $departmentId, $lastId, $sectionId) == "1") {
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
        $purpose = "Bypass Leave:" . $data['purpose'];

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
