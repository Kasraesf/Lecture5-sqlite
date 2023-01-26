<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

$db = new SQLite3('school.db');
$SQL_create_table = "CREATE TABLE IF NOT EXISTS Students
(
StudentId VARCHAR(10) NOT NULL,
FirstName VARCHAR(80),
LastName VARCHAR(80),
School VARCHAR(50),
PRIMARY KEY (StudentId)
);";
$db->exec($SQL_create_table);

// $SQL_insert_data = "INSERT INTO  Students (StudentId, FirstName, LastName, School)
// VALUES
// ('A00111111', 'Tom', 'Max', 'Science'),
// ('A00222222', 'Ann', 'Fay', 'Mining'),
// ('A00333333', 'Joe', 'Sun', 'Nursing'),
// ('A00444444', 'Sue', 'Fox', 'Computing'),
// ('A00555555', 'Ben', 'Ray', 'Mining')
// ";
// $db->exec($SQL_insert_data);


$res = $db->query('SELECT * FROM Students');
while ($row = $res->fetchArray()) {
echo "{$row['StudentId']} {$row['FirstName']} {$row['LastName']} {$row['School']}<br />";
}

$stm = $db->prepare('SELECT * FROM Students WHERE StudentId = ?');
$stm->bindValue(1, "A00333333", SQLITE3_TEXT);
$res = $stm->execute();
$row = $res->fetchArray(SQLITE3_NUM);
echo "<p>{$row[0]} {$row[1]} {$row[2]} {$row[3]}</p>";


$sql = "";
$sql .= 'SELECT * FROM Students';
$sql .= ' WHERE FirstName = ? AND LastName = ?';
echo "<p>$sql</p>";
$stm = $db->prepare( $sql );
$stm->bindParam(1, $firstName);
$stm->bindParam(2, $lastName);
$firstName = 'Sue';
$lastName = 'Fox';
$res = $stm->execute();
$row = $res->fetchArray(SQLITE3_NUM);
echo "<p>{$row[0]} {$row[1]} {$row[2]} {$row[3]}</p>";

$res = $db->query("SELECT * FROM Students");
$cols = $res->numColumns();
echo "<p>There are {$cols} columns in the result set.</p>";


$res = $db->query("PRAGMA table_info(Students)");
while ($row = $res->fetchArray(SQLITE3_NUM)) {
echo "<p>{$row[0]} {$row[1]} {$row[2]} {$row[3]} </p>";
}


$res = $db->query("SELECT * FROM Students");
$col0 = $res->columnName(0);
$col1 = $res->columnName(1);
$col2 = $res->columnName(2);
$col3 = $res->columnName(3);
$header = sprintf("%-10s %s %s %s\n", $col0, $col1, $col2, $col3);
echo "<p>$header</p>";
while ($row = $res->fetchArray()) {
$line = sprintf("<p>%-10s %s %s %s</p>", $row[0], $row[1], $row[2], $row[3]);
echo $line;
}


$res = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
$cols = $res->numColumns();
echo "<p>There are {$cols} columns in the result set.</p>";
while ($row = $res->fetchArray(SQLITE3_NUM)) {
echo "<p>{$row[0]}</p>";
}


$SQL_insert_data = "INSERT INTO Students (StudentId, FirstName, LastName, School)
VALUES
('A00666666', 'Tim', 'Day', 'Science'),
('A00777777', 'Zoe', 'Fry', 'Mining'),
('A00888888', 'Jim', 'Roy', 'Nursing'),
('A00999999', 'Fay', 'Lot', 'Computing')
";
$db->exec($SQL_insert_data);
$changes = $db->changes();
echo "<p>The INSERT statement added $changes rows</p>";

# close database
$db->close();

?>
</body>

</html>
