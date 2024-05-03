<?php
class DateWiseReceive extends DbhReport
{
    public function DateWiseReceiveReport($startDate, $endDate)
    {
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        // Format DateTime objects in a way compatible with SQL Server (assuming the 'Y-m-d H:i:s' format)
        $startDate = $startDateTime->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');

        session_start();
        $section=$_SESSION['section'];



        $sql = "
    SELECT 
        iss.is_po_no AS po_no, 
        d.d_name AS department, 
        iss.is_datetime AS issue_date, 
        c.c_name AS category, 
        i.i_name AS item, 
        i.i_manufactured_by AS brand, 
        i.i_size AS size, 

        ist.ist_price AS purchase_price, 
        iss.is_qty AS quantity, 
        i.i_unit AS units, 
        COALESCE(ist.total_price, 0) AS total_price
    FROM 
        item_issue iss 
    INNER JOIN 
        employee e ON iss.e_id = e.e_id
    INNER JOIN
        department d ON e.d_id = d.d_id
    INNER JOIN
        item i ON iss.i_id = i.i_id
    INNER JOIN 
        category_item c ON c.c_id = i.c_id
    INNER JOIN (SELECT SUM(ist_qty*ist_price) as total_price, is_id, SUM(ist_qty*ist_price)/SUM(ist_qty) as ist_price FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
    
                   WHERE i.section ='$section' AND iss.is_active = 1 AND iss.is_datetime BETWEEN '$startDate' AND '$endDate'
    ORDER BY c.c_name,i.i_name
";


        $stmt = $this->connect()->query($sql);
        if(!$stmt){
            return [];
        }else{
            $result = $stmt->fetchAll();
            return $result;
        }

    }

    public function DateWiseNameReceiveReport($startDate, $endDate, $itemName)
    {
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        // Format DateTime objects in a way compatible with SQL Server (assuming the 'Y-m-d H:i:s' format)
        $startDate = $startDateTime->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');

        session_start();
        $section=$_SESSION['section'];




        $sql = "
    SELECT 
        iss.is_po_no AS po_no, 
        d.d_name AS department, 
        iss.is_datetime AS issue_date, 
        c.c_name AS category, 
        i.i_name AS item, 
        i.i_manufactured_by AS brand, 
        i.i_size AS size, 
        ist.ist_price AS purchase_price, 
        iss.is_qty AS quantity, 
        i.i_unit AS units, 
        COALESCE(ist.total_price, 0) AS total_price
    FROM 
        item_issue iss 
    INNER JOIN 
        employee e ON iss.e_id = e.e_id
    INNER JOIN
        department d ON e.d_id = d.d_id
    INNER JOIN
        item i ON iss.i_id = i.i_id
    INNER JOIN 
        category_item c ON c.c_id = i.c_id
    INNER JOIN (SELECT SUM(ist_qty*ist_price) as total_price, is_id, AVG(ist_price) as ist_price FROM item_issue_trac GROUP BY is_id) ist ON ist.is_id = iss.is_id
    
   WHERE i.section ='$section' AND iss.is_active = 1 AND iss.is_datetime BETWEEN '$startDate' AND '$endDate' AND i.i_name LIKE '%$itemName%'
ORDER BY 
c.c_name,i.i_name
        ";
        $stmt = $this->connect()->query($sql);
        if(!$stmt){
            return [];
        }else{
            $result = $stmt->fetchAll();
            return $result;
        }

    }
}
