<?php
class DateWiseReceive extends DbhReport
{
    public function DateWiseReceiveReport($startDate, $endDate)
    {
        session_start();
        $section=$_SESSION['section'];
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        // Format DateTime objects in a way compatible with SQL Server (assuming the 'Y-m-d H:i:s' format)
        $startDate = $startDateTime->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');
       
        $sql = "
       SELECT 
    ip.p_po_no AS po_no, 
    COALESCE(s.s_name, '-') AS supplier, 
    COALESCE(r.p_recive_datetime, '-') AS date, 
    c.c_name AS category, 
    i.i_name AS item, 
    i.i_manufactured_by AS brand, 
    i.i_size AS size, 
    i.i_price as item_price, ip.p_unit_price as purchase_price,
    COALESCE(r.p_recive_qty, 0) AS quantity, 
    i.i_unit AS units, 
    COALESCE(r.p_recive_qty * ip.p_unit_price, 0) AS total_price,
    CASE
        WHEN r.cash1_creadit0 = 1 THEN 'Cash'
        WHEN r.cash1_creadit0 = 0 THEN 'Credit'
        ELSE 'Unknown' -- Optional: handle other values
    END AS cash1_creadit0
FROM 
    item_purchase ip 
INNER JOIN 
    item i ON i.i_id = ip.i_id
INNER JOIN 
    category_item c ON c.c_id = i.c_id
INNER JOIN 
    supplier s ON s.s_id = ip.s_id
INNER JOIN 
    tem_purchase_recive r ON r.p_id = ip.p_id 
    Where i.section ='$section' and r.p_recive_datetime BETWEEN '$startDate' AND '$endDate'

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

    public function DateWiseNameReceiveReport($startDate, $endDate, $itemName)
    {
        session_start();
        $section=$_SESSION['section'];
        
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        // Format DateTime objects in a way compatible with SQL Server (assuming the 'Y-m-d H:i:s' format)
        $startDate = $startDateTime->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');
        $sql = "
        SELECT ip.p_po_no as po_no, s.s_name as supplier, r.p_recive_datetime as date, c.c_name category, 
        i.i_name as item, i.i_manufactured_by as brand, i.i_size as size, i.i_price as item_price, ip.p_unit_price as purchase_price, 
        r.p_recive_qty as quantity, i.i_unit as units, r.p_recive_qty * ip.p_unit_price as total_price, 
        CASE
        WHEN r.cash1_creadit0 = 1 THEN 'Cash'
        WHEN r.cash1_creadit0 = 0 THEN 'Credit'
        ELSE 'Unknown' -- Optional: handle other values
    END AS cash1_creadit0
        FROM item_purchase ip 
        LEFT JOIN tem_purchase_recive r ON r.p_id=ip.p_id 
        INNER JOIN supplier s ON s.s_id=ip.s_id
        INNER JOIN item i ON i.i_id=ip.i_id
        INNER JOIN category_item c ON c.c_id=i.c_id  
        WHERE i.section ='$section' AND i.i_name LIKE '%$itemName%' AND r.p_recive_datetime BETWEEN '$startDate' AND '$endDate'
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
}
