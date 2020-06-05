<a href = "index.php">回首頁</a> <p>
<a href = "加選.php">加選課程</a> <p>

<?php
header('Content-Type: text/html; charset=utf-8');
if (isset($_POST['MyHead'])) {
    $MyHead = $_POST["MyHead"];
    $dbhost = '127.0.0.1';
    $dbuser = 'hj';
    $dbpass = 'test1234';
    $dbname = 'testdb';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysqli_query($conn, "SET NAMES 'utf8'");
    mysqli_select_db($conn, $dbname);
    $sql = "SELECT 姓名 FROM people where id LIKE \"" . $MyHead . "%\";";
    $result = mysqli_query($conn, $sql) or die('MySQL query error');

    if ($row = mysqli_fetch_array($result)) {
        $id = $_POST['MyHead'];
        $sql_class = "SELECT * FROM people where id='$id' ";
        $result_class = mysqli_query($conn, $sql_class);
        $classname = mysqli_fetch_array($result_class, MYSQLI_BOTH);
        printf("%s同學您好,你的課表如下:<br><br >", $classname["姓名"]);
        $sql_tb = "SELECT * FROM db_table_course where 班級 = '$classname[2]' ";
        $result_tb = mysqli_query($conn, $sql_tb);
        if (!$result_tb) {
            echo ("Error: " . mysqli_error($conn));
            exit();
  }
  echo "$classname[2]";
        echo "<table border=1 width=400 cellpadding=5>";
        echo "<tr>
         <td>課程名稱</td>
         <td>授課教師</td>
         <td>星期</td>
         <td>節</td>
      </tr>";

        while ($row1 = mysqli_fetch_array($result_tb, MYSQLI_BOTH)) {
   
            $sql_time = "SELECT * FROM db_table_time where 代號 = '$row1[2]' ";
            $result_time = mysqli_query($conn, $sql_time);
			$row2 = mysqli_fetch_array($result_time, MYSQLI_BOTH);
			if (!$result_time) {
				printf("Error: %s\n", mysqli_error($conn));
				exit();
			   }
            echo "<tr>
         <td>$row1[1]</td>
         <td>$row1[8]</td>
         <td>$row2[1]</td>
         <td>$row2[2]</td>
         </tr>";
        }
        echo "</table>";
    } else {
        echo "學號輸入錯誤,請重新輸入";
    }
}
?>