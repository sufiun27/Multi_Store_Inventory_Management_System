<?php

class DateWiseReceive extends DbhReport
{
    public function ReceiveReport($department,$item_name)
    {
        session_start();
$section=$_SESSION['section'];


        
        $sql = "
        SELECT 
    subquery.d_name, subquery.c_name, subquery.i_name, subquery.i_unit, subquery.i_size, 
    SUM(subquery.is_qty) AS quantity, 
    subquery.i_price AS system_price,
    SUM(subquery.total_price) / SUM(subquery.is_qty) AS avg_price,
    SUM(subquery.total_price) AS total_price,
    ROUND((SUM(subquery.total_price) * 100) / vis.total_item_issue_price, 2) as percentage
FROM (
    SELECT 
        iss.is_id, i.i_name, i.i_id, c.c_name, 
        i.i_size, i.i_unit, i.i_price,
        iss.is_qty, ist.total_price AS total_price, 
        iss.is_datetime, iss.is_item_issue_by, 
        e.e_com_id, e.e_name, d.d_name, d.d_id
    FROM item_issue iss 
    INNER JOIN item i ON iss.i_id = i.i_id 
    INNER JOIN employee e ON iss.e_id = e.e_id
    INNER JOIN department d ON d.d_id = e.d_id
    INNER JOIN category_item c ON i.c_id = c.c_id
    INNER JOIN (
        SELECT SUM(ist_qty * ist_price) AS total_price, is_id 
        FROM item_issue_trac 
        GROUP BY is_id
    ) ist ON ist.is_id = iss.is_id
    WHERE i.section ='$section' AND c.c_name LIKE '%" . $item_name . "%' AND d.d_name LIKE '%" . $department . "%'  
) AS subquery 
INNER JOIN view_item_issue vis ON vis.i_id = subquery.i_id 
GROUP BY subquery.d_id,subquery.i_id, subquery.d_name, subquery.c_name, 
subquery.i_name, subquery.i_unit, subquery.i_size, subquery.i_price, vis.total_item_issue_price";

        $stmt = $this->connect()->query($sql);

        if (!$stmt) {
            return [];
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }

    public function DateWiseNameReceiveReport($item_name, $department, $start_date, $end_date)
    {
        session_start();
$section=$_SESSION['section'];


        
        $startDateTime = new DateTime($start_date);
        $endDateTime = new DateTime($end_date);

        // Format DateTime objects in a way compatible with SQL Server (assuming the 'Y-m-d H:i:s' format)
        $start_date = $startDateTime->format('Y-m-d H:i:s');
        $end_date = $endDateTime->format('Y-m-d H:i:s');
        $sql = "
        SELECT 
    subquery.d_name, subquery.c_name, subquery.i_name, subquery.i_unit, subquery.i_size, 
    SUM(subquery.is_qty) AS quantity, 
    subquery.i_price AS system_price,
    SUM(subquery.total_price) / SUM(subquery.is_qty) AS avg_price,
    SUM(subquery.total_price) AS total_price,
    ROUND((SUM(subquery.total_price) * 100) / vis.total_item_issue_price, 2) as percentage
FROM (
    SELECT 
        iss.is_id, i.i_name, i.i_id, c.c_name, 
        i.i_size, i.i_unit, i.i_price,
        iss.is_qty, ist.total_price AS total_price, 
        iss.is_datetime, iss.is_item_issue_by, 
        e.e_com_id, e.e_name, d.d_name, d.d_id
    FROM item_issue iss 
    INNER JOIN item i ON iss.i_id = i.i_id 
    INNER JOIN employee e ON iss.e_id = e.e_id
    INNER JOIN department d ON d.d_id = e.d_id
    INNER JOIN category_item c ON i.c_id = c.c_id
    INNER JOIN (
        SELECT SUM(ist_qty * ist_price) AS total_price, is_id 
        FROM item_issue_trac 
        GROUP BY is_id
    ) ist ON ist.is_id = iss.is_id
    WHERE i.section ='$section' AND  c.c_name LIKE '%" . $item_name . "%' AND d.d_name LIKE '%" . $department . "%' AND iss.is_datetime BETWEEN '" . $start_date . "' AND '" . $end_date . "'
) AS subquery 
INNER JOIN view_item_issue vis ON vis.i_id = subquery.i_id 
GROUP BY subquery.d_id,subquery.i_id, subquery.d_name, subquery.c_name, 
subquery.i_name, subquery.i_unit, subquery.i_size, subquery.i_price, vis.total_item_issue_price";

        $stmt = $this->connect()->query($sql);
        
        if (!$stmt) {
            return [];
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }

    public function DepartmentsName()

    {
        
        $sql = "SELECT d_name, d_id From department";

        $stmt = $this->connect()->query($sql);

        if (!$stmt) {
            return [];
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }

    public function ItemsName()

    {
        session_start();
        $section=$_SESSION['section'];

        $sql = "SELECT c_name, c_id From category_item where section ='$section'";

        $stmt = $this->connect()->query($sql);

        if (!$stmt) {
            return [];
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }
}
