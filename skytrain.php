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
        <h2>Skytrain Page</h2>
        <p>This is the Skytrain page of the project with actions relating to Skytrain.</p>
        
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

        <h2>Insert a new Skytrain</h2>

        <form method="POST" action="skytrain.php"> <!--refresh page when submitted-->
            <h3>Vehicle Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            +*Serial Number: <input type="text" name="insSN"> <br /><br />
            +Junction Name: <input type="text" name="insJunction"> <br /><br />
            +Route ID: <input type="text" name="insRoute"> <br /><br />
            *Status: <input type="text" name="insStatus"> <br /><br />
            *Current Location: <input type="text" name="insLocation"> <br /><br />
            *Number of Passengers: <input type="text" name="insPassengers"> <br /><br />
            <h3>Skytrain Data</h3>
            *Line: <input type="text" name="insLine"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>



        <hr />

        <h2>Update Attribute of a Skytrain</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all Skytrain tuples with old attribute with new attribute.
        </p>

        <form method="POST" action="skytrain.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            <select name="oldAttribute"> 
                <option value='serialNumber'> +*Serial Number </option>
                <option value='junctionName'> +Junction Name </option>
                <option value='routeID'> +Route ID </option>
                <option value='status'> +Status+ </option>
                <option value='current_location'> *Current Location </option>
                <option value='numPassengers'> *Number of Passengers </option>
                <option value='line'> *Line </option>
            </select>
            <input type="text" name="oldAttributeValue"> <br /><br />
            <select name="newAttribute"> 
                <option value='junctionName'> +Junction Name </option>
                <option value='routeID'> +Route ID </option>
                <option value='status'> *Status </option>
                <option value='current_location'> *Current Location </option>
                <option value='numPassengers'> *Number of Passengers </option>
                <option value='line'> *Line </option>
            </select>
            <input type="text" name="newAttributeValue"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Delete a Skytrain</h2>
        <p>Deletes any Skytrain with the following attribute(s) </p>
        <form method="POST" action="skytrain.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <select name="attribute"> 
                <option value='serialNumber'> +*Serial Number </option>
                <option value='junctionName'> +Junction Name </option>
                <option value='routeID'> +Route ID </option>
                <option value='status'> +Status+ </option>
                <option value='current_location'> *Current Location </option>
                <option value='numPassengers'> *Number of Passengers </option>
                <option value='line'> *Line </option>
            </select>
            <select name="comparison">
                <option value='='> = </option>
                <option value='<='> <= </option>
                <option value='>='> >= </option>
                <option value='<'> < </option>
                <option value='>'> > </option>
            </select>
            <input type="text" name="value"><br><br>
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />
        <h2>Count Skytrains</h2>
        <form method="GET" action="skytrain.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples">
        </form>

        <hr />

        <h2>Project and Display all Skytrains</h2>
        <form method="GET" action="skytrain.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="checkbox" name="cSerial" value='vehicle.serialNumber' checked></input>Serial Number<br>
            <input type="checkbox" name="cJunction" value='junctionName' checked></input>Junction Name<br>
            <input type="checkbox" name="cRoute" value='routeID' checked></input>Route ID<br>
            <input type="checkbox" name="cStatus" value='status' checked></input>Status<br>
            <input type="checkbox" name="cLocation" value='current_location' checked></input>Current Location<br>
            <input type="checkbox" name="cPassengers" value='numPassengers' checked></input>Passengers<br>
            <input type="checkbox" name="cLine" value='line' checked></input>Line<br>
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Project and Select Skytrains</h2>
        <form method="GET" action="skytrain.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectTupleRequest" name="selectTupleRequest">

            <input type="checkbox" name="cSerial" value='vehicle.serialNumber' checked></input>Serial Number<br>
            <input type="checkbox" name="cJunction" value='junctionName' checked></input>Junction Name<br>
            <input type="checkbox" name="cRoute" value='routeID' checked></input>Route ID<br>
            <input type="checkbox" name="cStatus" value='status' checked></input>Status<br>
            <input type="checkbox" name="cLocation" value='current_location' checked></input>Current Location<br>
            <input type="checkbox" name="cPassengers" value='numPassengers' checked></input>Passengers<br>     
            <input type="checkbox" name="cLine" value='line' checked></input>Line<br>

            <select name="attribute">
                <option value='vehicle.serialNumber'> Serial Number </option>
                <option value='junctionName'> Junction Name </option>
                <option value='routeID'> Route ID </option>
                <option value='status'> Status </option>
                <option value='current_location'> Current Location </option>
                <option value='numPassengers'> Number of Passengers </option>
                <option value='line'> Line </option>
            </select>
            <select name="comparison">
                <option value='='> = </option>
                <option value='<='> <= </option>
                <option value='>='> >= </option>
                <option value='<'> < </option>
                <option value='>'> > </option>
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
            echo "<br>Retrieved Skytrain data:<br>";
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

            $route;
            $junction;

            if (isset($_POST['insRoute'])) {
                $route = $_POST['insRoute'];
            } else {
                $route = "null";
                // echo('is set null')
            }

            if (isset($_POST['insJunction'])) {
                $junction = $_POST['insJunction'];
            } else {
                $junction = "null";
            }


            $vehicleTuple = array (
                ":bind1" => $_POST['insSN'],
                ":bind2" => $_POST['insJunction'],
                ":bind3" => $route,
                ":bind4" => $_POST['insStatus'],
                ":bind5" => $_POST['insLocation'],
                ":bind6" => $_POST['insPassengers']
            );

            $skyTuple = array(
                ":bind1" => $_POST['insSN'],
                ":bind2" => $_POST['insLine']
            );


            $allVehicleTuples = array (
                $vehicleTuple
            );

            $allSkyTuples = array(
                $skyTuple
            );

            executeBoundSQL("insert into vehicle values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $allVehicleTuples);
            executeBoundSQL("insert into skytrain values (:bind1, :bind2)", $allSkyTuples);
            OCICommit($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $vehicleAttributes = array(
                'serialNumber', 'junctionName',
                'routeID', 'status',
                'current_location', 'numPassengers'
            );

            $skyAttributes = array('serialNumber', 'line');


            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $command;
            // will only update within same table, will be easier to code for
            if (in_array($oldAttribute, $vehicleAttributes) and in_array($newAttribute, $vehicleAttributes)) {
                $command = "UPDATE vehicle SET " . $newAttribute . " = ";
                if ($newAttribute != 'numPassengers') {
                    $command .= "'" . $newValue . "'";
                } else {
                    $command .= $newValue;
                }
                $command .= " WHERE " . $oldAttribute . " = ";
                if ($oldAttribute != 'numPassengers') {
                    $command .= "'" . $oldValue . "'";
                } else {
                    $command .= $oldValue;
                }
                executePlainSQL($command);
            } else if (in_array($oldAttribute, $skyAttributes) and in_array($newAttribute, $skyAttributes)) {
                $command = "UPDATE skytrain SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute ." = '" . $oldValue . "'";
                executePlainSQL($command);
            }else {
                echo("Selected attributes are not from same table and are not compatible");
            }
            echo("Successfully updated Skytrain!");
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

            if ($_POST['attribute'] == 'line') {
                $result = executePlainSQL("SELECT serialNumber from skytrain where line " . $_POST['comparison'] . " '" . $value . "'");
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    executePlainSQL("DELETE from vehicle where serialNumber = '" . $row['SERIALNUMBER'] . "'");
                }
     
            } else {
                if ($_POST['attribute'] == 'numPassengers') {
                    executePlainSQL('delete from vehicle where ' . $_POST['attribute'] . $_POST['comparison'] . $value);
                    // echo('dlt passengers');
                } else {
                    executePlainSQL('delete from vehicle where ' . $_POST['attribute'] . $_POST['comparison'] . "'" . $value . "'");
                    // echo('something else ahppened');
                }
            }

            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM skytrain");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of Skytrains: " . $row[0] . "<br>";
            }
        }

        function handleDisplayRequest() {
            global $db_conn;

            $command = "SELECT ";
            $list = array();
            if (isset($_GET['cSerial'])) {
                echo $_GET['cSerial'];
                $command .= $_GET['cSerial'] . ", ";
                array_push($list, 'Serial Number');
            }
            if (isset($_GET['cJunction'])) {
                $command .= $_GET['cJunction'] . ", ";
                array_push($list, 'Junction');
            }
            if (isset($_GET['cRoute'])) {
                $command .= $_GET['cRoute'] . ", ";
                array_push($list, 'Route ID');
            }
            if (isset($_GET['cStatus'])) {
                $command .= $_GET['cStatus'] . ", ";
                array_push($list, 'Status');
            }
            if (isset($_GET['cLocation'])) {
                $command .= $_GET['cLocation'] . ", ";
                array_push($list, 'Current Location');
            }
            if (isset($_GET['cPassengers'])) {
                $command .= $_GET['cPassengers'] . ", ";
                array_push($list, 'Passengers');
            }
            if (isset($_GET['cLine'])) {
                $command .= $_GET['cLine'] . ", ";
                array_push($list, 'Line');
            }
            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM vehicle INNER JOIN skytrain ON vehicle.serialNumber = skytrain.serialNumber";
            $result = executePlainSQL($command);
            printResult($result, $list);
        }

        function handleSelectRequest() {
            global $db_conn;

            $intAttributes = array('numPassengers', 'maxCapacity');
            $value;

            if (($_GET['value'] != '')) {
                if (in_array($_GET['value'], $intAttributes)) {
                    $value = $_GET['value'];
                } else {
                    $value = "'" . $_GET['value'] . "'";
                }
            } else {
                $value = 'null';
            }            
            $list = array();

            $command = "SELECT ";
            if (isset($_GET['cSerial'])) {
                $command .= $_GET['cSerial'] . ", ";
                array_push($list, 'Serial Number');
            }
            if (isset($_GET['cJunction'])) {
                $command .= $_GET['cJunction'] . ", ";
                array_push($list, 'Junction');
            }
            if (isset($_GET['cRoute'])) {
                $command .= $_GET['cRoute'] . ", ";
                array_push($list, 'Route ID');
            }
            if (isset($_GET['cStatus'])) {
                $command .= $_GET['cStatus'] . ", ";
                array_push($list, 'Status');
            }
            if (isset($_GET['cLocation'])) {
                $command .= $_GET['cLocation'] . ", ";
                array_push($list, 'Current Location');
            }
            if (isset($_GET['cPassengers'])) {
                $command .= $_GET['cPassengers'] . ", ";
                array_push($list, 'Passengers');
            }
            if (isset($_GET['cLine'])) {
                $command .= $_GET['cLine'] . ", ";
                array_push($list, 'Line');
            }
            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM vehicle INNER JOIN skytrain ON vehicle.serialNumber = skytrain.serialNumber WHERE " . $_GET['attribute'] ;
            
            if ($value != 'null') {
                $command .= " " . $_GET['comparison'] . " " . $value;
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
