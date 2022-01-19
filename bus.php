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
        <h2>Bus Page</h2>
        <p>This is the bus page of the project with actions relating to bus.</p>
        
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

        <h2>Insert a new Bus</h2>

        <form method="POST" action="bus.php"> <!--refresh page when submitted-->
            <h3>Vehicle Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            +*Serial Number: <input type="text" name="insSN"> <br /><br />
            +Junction Name: <input type="text" name="insJunction"> <br /><br />
            +Route ID: <input type="text" name="insRoute"> <br /><br />
            *Status: <input type="text" name="insStatus"> <br /><br />
            *Current Location: <input type="text" name="insLocation"> <br /><br />
            *Number of Passengers: <input type="text" name="insPassengers"> <br /><br />
            <h3>Bus Data</h3>
            *Type: <input type="text" name="insType"> <br /><br />
            *Maximum Capacity: <input type="text" name="insCapacity"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>



        <hr />

        <h2>Update Attribute of a Bus</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all bus tuples with old attribute with new attribute. <br>
            Cannot update serial number of buses as Oracle does not support update on cascade.
        </p>

        <form method="POST" action="bus.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Update values that have<br>
            <select name="oldAttribute"> 
                <option value='serialNumber'> +*Serial Number </option>
                <option value='junctionName'> +Junction Name </option>
                <option value='routeID'> +Route ID </option>
                <option value='status'> +Status+ </option>
                <option value='current_location'> *Current Location </option>
                <option value='numPassengers'> *Number of Passengers </option>
                <option value='type'> *Type </option>
                <option value='maxCapacity'> *Maximum Capacity </option>
            </select>
            <input type="text" name="oldAttributeValue"> <br /><br />
            and change<br>
            <select name="newAttribute"> 
                <option value='junctionName'> +Junction Name </option>
                <option value='routeID'> +Route ID </option>
                <option value='status'> *Status </option>
                <option value='current_location'> *Current Location </option>
                <option value='numPassengers'> *Number of Passengers </option>
                <option value='type'> *Type </option>
                <option value='maxCapacity'> *Maximum Capacity </option>
            </select>
            <input type="text" name="newAttributeValue"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Delete a Bus</h2>
        <p>Deletes any bus with the following attribute(s) </p>
        <form method="POST" action="bus.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <select name="attribute"> 
                <option value='serialNumber'> +*Serial Number </option>
                <option value='junctionName'> +Junction Name </option>
                <option value='routeID'> +Route ID </option>
                <option value='status'> +Status+ </option>
                <option value='current_location'> *Current Location </option>
                <option value='numPassengers'> *Number of Passengers </option>
                <option value='type'> *Type </option>
                <option value='maxCapacity'> *Maximum Capacity </option>
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
        <h2>Count Types of Buses</h2>
        <form method="GET" action="bus.php">
            Returns a table with the total number of every type of bus. <br>
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" value="Count" name="countTuples">
        </form>

        <hr />
        <h2>Get Calm Buses</h2>
        <p>Displays buses with below number of passengers of all bus types</p>
        <form method="GET" action="bus.php">
            <input type="hidden" id="calmTupleRequest" name="calmTupleRequest">
            <input type="submit" name="calmTuples">
        </form>

        <hr />

        <h2>Project and Display all Buses</h2>
        <p>Displays all buses with selected attributes in a table.</p>
        <form method="GET" action="bus.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="checkbox" name="cSerial" value='vehicle.serialNumber' checked></input>Serial Number<br>
            <input type="checkbox" name="cJunction" value='junctionName' checked></input>Junction Name<br>
            <input type="checkbox" name="cRoute" value='routeID' checked></input>Route ID<br>
            <input type="checkbox" name="cStatus" value='status' checked></input>Status<br>
            <input type="checkbox" name="cLocation" value='current_location' checked></input>Current Location<br>
            <input type="checkbox" name="cPassengers" value='numPassengers' checked></input>Passengers<br>
            <input type="checkbox" name="cType" value='type' checked></input>Type<br>
            <input type="checkbox" name="cCapacity" value='maxCapacity' checked></input>Max Capacity<br>
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Project and Select Buses</h2>
        <p>Displays all buses with selected attribute and where a selected value is equals to.</p>
        <form method="GET" action="bus.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectTupleRequest" name="selectTupleRequest">

            <input type="checkbox" name="cSerial" value='vehicle.serialNumber' checked></input>Serial Number<br>
            <input type="checkbox" name="cJunction" value='junctionName' checked></input>Junction Name<br>
            <input type="checkbox" name="cRoute" value='routeID' checked></input>Route ID<br>
            <input type="checkbox" name="cStatus" value='status' checked></input>Status<br>
            <input type="checkbox" name="cLocation" value='current_location' checked></input>Current Location<br>
            <input type="checkbox" name="cPassengers" value='numPassengers' checked></input>Passengers<br>
            <input type="checkbox" name="cType" value='type' checked></input>Type<br>
            <input type="checkbox" name="cCapacity" value='maxCapacity' checked></input>Max Capacity<br>

            <select name="attribute">
                <option value='vehicle.serialNumber'> Serial Number </option>
                <option value='junctionName'> Junction Name </option>
                <option value='routeID'> Route ID </option>
                <option value='status'> Status </option>
                <option value='current_location'> Current Location </option>
                <option value='numPassengers'> Number of Passengers </option>
                <option value='type'> Type </option>
                <option value='maxCapacity'> Maximum Capacity </option>
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
            echo "<br>Retrieved bus data:<br>";
            echo "<table style='width:50%' border=1>";
            echo "<tr>";
            foreach ($head as $name) {
                echo "<th>" . $name . "</th>";
            }
            echo "</tr>";


            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>";
                for ($i = 0; $i < count($head); $i++) {
                    echo "<td>" . $row[$i] . "</td>";
                }
                echo "</tr>";
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

            $bus1Tuple = array(
                ":bind1" => $_POST['insSN'],
                ":bind2" => $_POST['insType']
            );

            $bus2Tuple = array(
                ":bind1" => $_POST['insSN'],
                ":bind2" => $_POST['insCapacity']
            );

            $allVehicleTuples = array (
                $vehicleTuple
            );

            $allBus1Tuples = array(
                $bus1Tuple
            );

            $allBus2Tuples = array(
                $bus2Tuple
            );

            executeBoundSQL("insert into vehicle values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $allVehicleTuples);
            executeBoundSQL("insert into bus1 values (:bind1, :bind2)", $allBus1Tuples);
            executeBoundSQL("insert into bus2 values (:bind1, :bind2)", $allBus2Tuples);
            OCICommit($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $vehicleAttributes = array(
                'serialNumber', 'junctionName',
                'routeID', 'status',
                'current_location', 'numPassengers'
            );

            $bus1Attributes = array('serialNumber', 'type');
            $bus2Attributes = array('serialNumber', 'maxCapacity');


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
            } else if (in_array($oldAttribute, $bus1Attributes) and in_array($newAttribute, $bus1Attributes)) {
                $command = "UPDATE bus1 SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute ." = '" . $oldValue . "'";
                executePlainSQL($command);
            } else if (in_array($oldAttribute, $bus2Attributes) and in_array($newAttribute, $bus2Attributes)) {
                $command = "UPDATE bus2 SET " . $newAttribute . " = " . $newValue . " WHERE " . $oldAttribute . " = ";
                if ($oldAttribute == 'maxCapacity') {
                    $command .=  $oldValue;
                } else {
                    $command .= "'" . $oldValue . "'";
                }
                executePlainSQL($command);
            } else {
                echo("Selected attributes are not from same table and are not compatible");
            }
            echo("Successfully updated bus!");
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

            if ($_POST['attribute'] == 'type') {
                $result = executePlainSQL("SELECT serialNumber from bus1 where type " . $_POST['comparison'] . " '" . $value . "'");
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    executePlainSQL("DELETE from vehicle where serialNumber = '" . $row['SERIALNUMBER'] . "'");
                }
     
            } else if ($_POST['attribute'] == 'maxCapacity') {
                $result = executePlainSQL("SELECT serialNumber from bus2 where maxCapacity " . $_POST['comparison'] . " " . $_POST['value']);
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    executePlainSQL("DELETE from vehicle where serialNumber = '" . $row['SERIALNUMBER'] . "'");
                }
            } else {
                if ($_POST['attribute'] == 'numPassengers') {
                    executePlainSQL('delete from vehicle where ' . $_POST['attribute'] . $_POST['comparison'] . $value);
                } else {
                    executePlainSQL('delete from vehicle where ' . $_POST['attribute'] . $_POST['comparison'] . "'" . $value . "'");
                }
            }

            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT type, Count(*) FROM bus1 GROUP BY type");

            printResult($result, array("Type", "Count"));
        }

        function handleCalmRequest() {
            global $db_conn;

            $allTable = "(SELECT * FROM vehicle natural JOIN bus1 natural JOIN bus2)";

            $command = "SELECT *
                        FROM " . $allTable . " v1 
                        WHERE (v1.numpassengers) <= ALL (SELECT avg(v2.numpassengers) 
                                                            FROM " . $allTable . " v2 
                                                            GROUP by type)";

            $list = array("Serial Number", "Junction", "Route ID", "Status", "Location", "Number of Passengers", "Type", "Max Capacity");
            $result = executePlainSQL($command);
            printResult($result, $list);
        }

        function handleDisplayRequest() {
            global $db_conn;

            $command = "SELECT ";
            $list = array();
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
            if (isset($_GET['cType'])) {
                $command .= $_GET['cType'] . ", ";
                array_push($list, 'Type');
            }
            if (isset($_GET['cCapacity'])) {
                $command .= $_GET['cCapacity'] . ", ";
                array_push($list, 'Max Capacity');
            }
            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM vehicle INNER JOIN bus1 ON vehicle.serialNumber = bus1.serialNumber INNER JOIN bus2 on vehicle.serialNumber = bus2.serialNumber";
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
            if (isset($_GET['cType'])) {
                $command .= $_GET['cType'] . ", ";
                array_push($list, 'Type');
            }
            if (isset($_GET['cCapacity'])) {
                $command .= $_GET['cCapacity'] . ", ";
                array_push($list, 'Max Capacity');
            }
            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM vehicle INNER JOIN bus1 ON vehicle.serialNumber = bus1.serialNumber INNER JOIN bus2 on vehicle.serialNumber = bus2.serialNumber WHERE " . $_GET['attribute'] ;
            
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
                if (array_key_exists('calmTuples', $_GET)) {
                    handleCalmRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest']) || isset($_GET['selectTupleRequest']) || isset($_GET['calmTupleRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>
