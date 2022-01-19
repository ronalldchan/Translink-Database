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
        <h2>Route Page</h2>
        <p>This is the route page of the project.</p>
        
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

        <h2>Insert a new Route</h2>

        <form method="POST" action="route.php"> <!--refresh page when submitted-->
            <h3>Route Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            *Route ID: <input type="text" name="insRoute" required> <br /><br />
            *Start Location: <input type="text" name="insStart" required> <br /><br />
            *End Location: <input type="text" name="insEnd" required> <br /><br />
            Number of Stops: <input type="text" name="insStops"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Update Attribute of a Route</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all route tuples with old attribute with new attribute.
        </p>

        <form method="POST" action="route.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            <select name="oldAttribute"> 
                <option value='routeID'> *Route ID </option>
                <option value='start_location'> *Start Location </option>
                <option value='end_location'> *End Location </option>
                <option value='num_stops'> Number of Stops </option>
            </select>
            <input type="text" name="oldAttributeValue"> <br /><br />
            <select name="newAttribute"> 
                <option value='start_location'> *Start Location </option>
                <option value='end_location'> *End Location </option>
                <option value='num_stops'> Number of Stops </option>
            </select>
            <input type="text" name="newAttributeValue"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Delete a Route</h2>
        <p>Deletes any route with the following attribute(s) </p>
        <form method="POST" action="route.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <select name="attribute"> 
                <option value='routeID'> *Route ID </option>
                <option value='start_location'> *Start Location </option>
                <option value='end_location'> *End Location </option>
                <option value='num_stops'> Number of Stops </option>
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
        <h2>Count Routes</h2>
        <form method="GET" action="route.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples">
        </form>

        <hr />

        <h2>Display all Routes</h2>
        <form method="GET" action="route.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Project and Select Route</h2>
        <form method="GET" action="route.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectTupleRequest" name="selectTupleRequest">

            <input type="checkbox" name="cRouteID" value='routeID' checked></input>Route ID<br>
            <input type="checkbox" name="cStart" value='start_location' checked></input>Start Location<br>
            <input type="checkbox" name="cEnd" value='end_location' checked></input>End Location<br>
            <input type="checkbox" name="cNumStops" value='num_stops' checked></input>Number of Stops<br>
            <select name="attribute">
                <option value='routeID'> RouteID</option>
                <option value='start_location'>Start Location</option>
                <option value='end_location'>End Location</option>
                <option value='num_stops'>Number of Stops</option>
            </select>
            <select name="comparison">
                <option value='='> = </option>
                <option value='<='> <= </option>
                <option value='>='> >= </option>
                <option value='<'> < </option>
                <option value='>'> > </option>
            </select>
            <input type="text" name="value"><br><br>
            <input type="submit" name="selectTuples">
        </form>

        <hr />

        <h2>Add a Stop to a Route</h2>
        <form method="POST" action="route.php">
        <input type="hidden" id="insertContainsQueryRequest" name="insertContainsQueryRequest">
            *Route ID: <input type="text" name="insRoute" required> <br /><br />
            +*Stop ID: <input type="text" name="insStop" required> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit">
        </form>

        <hr />

        <h2>Display all Routes WITH Stops</h2>
        <form method="GET" action="route.php">
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayContainsTuples">
        </form>

        <hr />

        <h2> Display all Routes WHICH CONTAIN ALL STOPS</h2>
        <form method="GET" action="route.php">
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayDivisionTuples">
        </form>


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
            echo "<br>Retrieved route data:<br>";
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

            $route2Tuple = array(
                ":bind1" => $_POST['insStart'],
                ":bind2" => $_POST['insEnd'],
                ":bind3" => $_POST['insStops']
            );

            $route1Tuple = array(
                ":bind1" => $_POST['insRoute'],
                ":bind2" => $_POST['insStart'],
                ":bind3" => $_POST['insEnd']
            );

            $allRoute2Tuples = array(
                $route2Tuple
            );
            
            $allRoute1Tuples = array(
                $route1Tuple
            );

            executeBoundSQL("insert into route2 values (:bind1, :bind2, :bind3)", $allRoute2Tuples);
            executeBoundSQL("insert into route1 values (:bind1, :bind2, :bind3)", $allRoute1Tuples);
            OCICommit($db_conn);
        }

        function handleInsertContainsRequest() {
            global $db_conn;

            $containsTuple = array(
                ":bind1" => $_POST['insStop'],
                ":bind2" => $_POST['insRoute']
            );

            $allContainsTuples = array (
                $containsTuple
            );
            
            executeBoundSQL("insert into contains values (:bind1, :bind2)", $allContainsTuples);
            OCICommit($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $route1Attributes = array('routeID', 'start_location', 'end_location');
            $route2Attributes = array('start_location', 'end_location', 'num_stops');

            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $command = "";
            // if (in_array($oldAttribute, $route1Attributes) and in_array($newAttribute, $route1Attributes)) {
            //     $command = "UPDATE route1 SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute . " = '" . $oldValue . "'";
            //     executePlainSQL($command);
            // } else if (in_array($oldAttribute, $route2Attributes) and in_array($newAttribute, $route2Attributes)) {
            //     $command = "UPDATE route2 SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute . " = ";
            //     if ($oldAttribute == 'num_stops') {
            //         $command .= $oldValue;
            //     } else {
            //         $command .= "'" . $oldValue . "'";
            //     }
            //     executePlainSQL($command);
            // } else {
            //     echo("Selected attributes are not from same table and are not compatible");
            // }

            if ($oldAttribute == 'routeID') {
                $start_location = executePlainSQL("SELECT start_location FROM route1 WHERE routeID = " . $oldValue);
                $start_location = oci_fetch_row($start_location);
                $end_location = executePlainSQL("SELECT end_location FROM route1 WHERE routeID = " . $oldValue);
                $end_location = oci_fetch_row($end_location);
                $command = "UPDATE route2 SET " . $newAttribute . " = '" . $newValue . "' WHERE start_location = '" . $start_location[0] . "' AND end_location = '" . $end_location[0] . "'";
                executePlainSQL($command);
            } else if ($oldAttribute == 'num_stops') {
                executePlainSQL("UPDATE route2 SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute . " = " . $oldValue);
            } else {
                executePlainSQL("UPDATE route2 SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute . " = '" . $oldValue . "'");
            }
            OCICommit($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn;

            $value = "";
            if (isset($_POST['value'])) {
                $value = $_POST['value']; 
            } else {
                $value = 'NULL';
            }

            if ($_POST['attribute'] == 'routeID') {
                executePlainSQL("DELETE from route1 WHERE routeID " . $_POST['comparison'] . $value);
            } else if ($_POST['attribute'] == 'num_stops') {
                executePlainSQL("DELETE from route2 WHERE num_stops " . $_POST['comparison'] . $value);
            } else {
                executePlainSQL("DELETE from route2 WHERE " . $_POST['attribute'] . $_POST['comparison'] . "'" .$value . "'");
            }

            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM route1");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of routes: " . $row[0] . "<br>";
            }
        }

        function handleDisplayRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT route1.routeID, route1.start_location, route1.end_location, route2.num_stops
                                        FROM route1
                                            INNER JOIN route2
                                                ON (route1.start_location = route2.start_location AND route1.end_location = route2.end_location)");
            $list = array("Route ID", "Start Location", "End Location", "Number of Stops");
            printResult($result, $list);
        }

        function handleDisplayContainsRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM contains");
            $list = array("Stop ID", "Route ID");
            printResult($result, $list);
        }

        function handleDisplayDivisionRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM route1 
                                        WHERE NOT EXISTS (SELECT stopp.stoppID FROM stopp
                                            WHERE NOT EXISTS (SELECT contains.routeID FROM contains 
                                                WHERE stopp.stoppID = contains.stoppID 
                                                    AND contains.routeID = route1.routeID))
                                        ORDER BY routeID ASC");
            $list = array("Route ID", "Start Location", "End Location");
            printResult($result, $list);
        }

        function handleSelectRequest() {
            global $db_conn;

            $intAttributes = array('num_stops');

            $value = "";
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
            if (isset($_GET['cRouteID'])) {
                $command .= $_GET['cRouteID'] . ", ";
                array_push($list, 'Route ID');
            }
            if (isset($_GET['cStart'])) {
                $command .= $_GET['cStart'] . ", ";
                array_push($list, 'Start');
            }
            if (isset($_GET['cEnd'])) {
                $command .= $_GET['cEnd'] . ", ";
                array_push($list, 'End');
            }
            if (isset($_GET['cNumStops'])) {
                $command .= $_GET['cNumStops'] . ", ";
                array_push($list, 'Number of Stops');
            }
            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM (SELECT route1.routeID, route1.start_location, route1.end_location, route2.num_stops
                                        FROM route1
                                            INNER JOIN route2
                                                ON (route1.start_location = route2.start_location AND route1.end_location = route2.end_location))
                            WHERE " . $_GET['attribute'];
            
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
                } else if (array_key_exists('insertContainsQueryRequest', $_POST)) {
                    handleInsertContainsRequest();
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
                if (array_key_exists('displayContainsTuples', $_GET)) {
                    handleDisplayContainsRequest();
                }
                if (array_key_exists('displayDivisionTuples', $_GET)) {
                    handleDisplayDivisionRequest();
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
