<?php

class LeaveStatus extends Database
{
    public function getTable()
    {
        $query = "SELECT * FROM system_leaveform";
        $sql = $this->connect()->query($query);
        $data = [];
        $numberIncrement = 1;
        if ($sql->num_rows > 0) {
            while ($result = $sql->fetch_assoc()) {
                extract($result);

                $data[] = [
                    $numberIncrement,
                    $userFirstName,
                    $userSurname,
                    $userBirthday,
                    $userGender,
                    '<div class="btn-group">
                        <a class="btn btn-warning" href="val_editForm.php?userId=' . $userId . '">Edit</a>
                        <form action="val_phpTable" method="post">
                            <a class="btn btn-danger" onclick="deleteFunction(\'' . $userId . '\')">Delete</a>
                        </form>
                    </div>',
                ];
                $numberIncrement++;
            }
        }
        echo json_encode($data);  // send data as json format
    }
}
