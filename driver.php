<html>
    <head>
        <title>CPSC 304 Project: TransLink System</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <!-- contains modified code from Tutorial 7 -->
        <h1>CPSC 304 Project: TransLink System</h1>
        <div class="topnav">
            <a class="active" href="main.php">Home</a>
            <a href="about.html">About</a>
        </div>
        <h2>Driver Page</h2>
        <p>This is the driver page of the project with actions relating to bus.</p>
        
        <hr />

        <h2>Legend:</h2>
        <p>+ = Must come from pre-existing value<br>* = Required data</p>

        <form method="POST" action="main.php"> 
            <!-- POST is used to send data to server to create/update a resource -->
            <!-- action is where to send the data to-->
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <input type="submit" value="Reset" name="reset">
        </form>

        <hr />

        <h2>Insert a new Driver</h2>

        <form method="POST" action="driver.php"> <!--refresh page when submitted-->
            <h3>Driver Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            *Employee ID: <input type="text" name="insID"> <br /><br />
            *Full Name: <input type="text" name="insName"> <br /><br />
            +Bus Serial Number: <input type="text" name="insSN"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Update Attribute of a Driver</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all bus tuples with old attribute with new attribute.
        </p>

        <form method="POST" action="driver.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            <select name="oldAttribute"> 
                <option value='employeeID'> *Employee ID </option>
                <option value='driverName'> *Full Name </option>
                <option value='serialNumber'> +Serial Number </option>
            </select>
            <input type="text" name="oldAttributeValue"> <br /><br />
            <select name="newAttribute"> 
                <option value='driverName'> *Full Name </option>
                <option value='serialNumber'> +Serial Number </option>
            </select>
            <input type="text" name="newAttributeValue"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Delete a Driver</h2>
        <p>Deletes any bus with the following attribute(s) </p>
        <form method="POST" action="driver.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <select name="attribute"> 
                <option value='employeeID'> *Employee ID </option>
                <option value='driverName'> *Full Name </option>
                <option value='serialNumber'> +Serial Number </option>
            </select>
            <input type="text" name="value"><br><br>
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />
        <h2>Count Drivers</h2>
        <form method="GET" action="driver.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples">
        </form>

        <hr />

        <h2>Display all Drivers</h2>
        <form method="GET" action="driver.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Project and Select Drivers</h2>
        <form method="GET" action="driver.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectTupleRequest" name="selectTupleRequest">

            <input type="checkbox" name="cID" value='employeeID' checked></input>Employee ID<br>
            <input type="checkbox" name="cName" value='driverName' checked></input>Driver Name<br>
            <input type="checkbox" name="cSN" value='serialNumber' checked></input>Bus Serial Number<br>
            <select name="attribute">
                <option value='employeeID'> Employee ID </option>
                <option value='driverName'> Driver Name </option>
                <option value='serialNumber'> Bus Serial Number </option>
            </select>
            <input type="text" name="value"><br><br>
            <input type="submit" name="selectTuples"></p>
        </form>

        <hr />


        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP
        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr); 
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result, $head) { //prints results from a select statement
            echo "<br>Retrieved bus data:<br>";
            echo "<table style='width:50%' border=1>";
            echo "<tr>";
            // echo "<tr><th>Serial Number</th> <th>Junction</th> <th>Route ID</th> <th>Status</th> <th>Location</th> <th>Passengers</th> <th>Type</th> <th>Max Capacity</th> </tr>";
            foreach ($head as $name) {
                echo "<th>" . $name . "</th>";
            }
            echo "</tr>";


            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
                echo "<tr>";
                for ($i = 0; $i < count($head); $i++) {
                    echo "<td>" . $row[$i] . "</td>";
                }
                echo "</tr>";
                // echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td><td>" . $row[7] . "</td></tr>";
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_rchan05", "a58173758", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        // THIS WORKS!!!!!!!
        function runSQLFile($filename) {
            $fileString = file_get_contents($filename);
            $array = explode(';', $fileString);
            foreach ($array as $line) {
                if (substr($line, 0, 2) == '--' || $line == '') continue;
                executePlainSQL($line);
            }
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop and create table
            echo "<br> creating new table <br>";
            runSQLFile('main.sql');
            echo "<br> created new table <br>";
        
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table

            $serialNum;

            if (isset($_POST['insSN'])) {
                $serialNum = $_POST['insSN'];
            } else {
                $serialNum = "null";
            }

            $vehicleTuple = array (
                ":bind1" => $_POST['insID'],
                ":bind2" => $_POST['insName'],
                ":bind3" => $serialNum,
            );

            $allVehicleTuples = array (
                $vehicleTuple
            );

            executeBoundSQL("insert into driver values (:bind1, :bind2, :bind3)", $allVehicleTuples);
            OCICommit($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $command = "UPDATE driver SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute . " = '" . $oldValue . "'";
            executePlainSQL($command);
            OCICommit($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn;
            global $result;

            $value;
            if (isset($_POST['value'])) {
                $value = $_POST['value']; 
            } else {
                $value = 'NULL';
            }

            executePlainSQL("DELETE FROM driver WHERE " . $_POST['attribute'] . " = '" . $_POST['value'] . "'");
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM driver");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of drivers: " . $row[0] . "<br>";
            }
        }

        function handleDisplayRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM driver");
            $list = array("Employee ID", "Full Name", "Bus Serial Number");
            printResult($result, $list);
        }

        function handleSelectRequest() {
            global $db_conn;

            $value;

            if (($_GET['value'] != '')) {
                $value = "'" . $_GET['value'] . "'";
            } else {
                $value = 'null';
            }            

            $list = array();

            $command = "SELECT ";
            if (isset($_GET['cID'])) {
                $command .= $_GET['cID'] . ", ";
                array_push($list, 'Employee ID');
            }
            if (isset($_GET['cName'])) {
                $command .= $_GET['cName'] . ", ";
                array_push($list, 'Driver Name');
            }
            if (isset($_GET['cSN'])) {
                $command .= $_GET['cSN'] . ", ";
                array_push($list, 'Bus Serial Number');
            }
            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM driver WHERE " . $_GET['attribute'] ;
            
            if ($value != 'null') {
                $command .= " = " . $value;
            } else {
                $command .= " is null";
            }

            $result = executePlainSQL($command);
            printResult($result, $list);
        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                }
                if (array_key_exists('displayTuples', $_GET)) {
                    handleDisplayRequest();
                }
                if (array_key_exists('selectTuples', $_GET)) {
                    handleSelectRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest']) || isset($_GET['selectTupleRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>
