<?php

class LeaveForm extends Database
{

    private $orangePositions = array(
        "Assistant Supervisor", "Supervisor",
        "Assistant Manager", "Manager", "Deputy Factory Manager/PCO",
        "Technical Development /IT Dept. Manager/ Safety Officer",
        "Manager / Safety Officer"
    );

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

    public function insertLeave($id, $from, $to, $purpose)
    {
        $users = $this->getUser($id);

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
            $positionId = $pos['positionId'];
            $positionName = $pos['positionName'];
        }


        if ($this->checkString($positionName) == true) {
        }


        $sql = "INSERT INTO system_leaveform 
        (dateIssued, employeeNumber, employeeName, designation, department, purposeOfLeave, leaveFrom, leaveTo, status)
        VALUES (NOW, '$id', '$fullName', '$positionName', '$departmentName', '$purpose', '$from', '$to', '0')";
        $result = $this->connect()->query($sql);

        if ($result) {
        }
    }

    private function checkString($position)
    {
        if (in_array($position, $this->orangePositions)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM hr_employee WHERE status = 1 and employeeId = '$id'";
        $result = $this->connect()->query($sql);
        $users = array();

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

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

    private function getPosition($id)
    {
        $sql = "SELECT * FROM hr_position WHERE positionId = '$id'";
        $result = $this->connect()->query($sql);
        $position = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $position[] = $row;
            }
        }
        return $position;
    }

    private function insertNotification($id)
    {
        $date = date('Y-m-d');
        $newDate = strtotime($date);
        $sql = "INSERT INTO system_notificationdetails (notificationDetail, notificationKey, notificationType)
        VALUES ('You have a leave application waiting for approval', '$newDate', '33')";
    }
}
