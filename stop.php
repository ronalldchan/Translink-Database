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
        <h2>Stop Page</h2>
        <p>This is the stop page of the project.</p>
        
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

        <h2>Insert a new Stop</h2>

        <form method="POST" action="stop.php"> <!--refresh page when submitted-->
            <h3>Stop Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            *Stop ID: <input type="text" name="insSID" required> <br /><br />
            +*Junction Name: <input type="text" name="insJunction" required> <br /><br />
            *Location: <input type="text" name="insLoc" required> <br /><br />
            *Direction: <input type="text" name="insDir" required> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Update Attribute of a Stop</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all Stop tuples with old attribute with new attribute.
        </p>

        <form method="POST" action="stop.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            <select name="oldAttribute"> 
                <option value='stoppID'>*Stop ID</option>
                <option value='junctionName'>+*Junction Name</option>
                <option value='location'>*Location</option>
                <option value='direction'>*Direction</option>
            </select>
            <input type="text" name="oldAttributeValue"> <br /><br />
            <select name="newAttribute"> 
                <option value='junctionName'>+*Junction Name</option>
                <option value='location'>*Location</option>
                <option value='direction'>*Direction</option>
            </select>
            <input type="text" name="newAttributeValue"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Delete a Stop</h2>
        <p>Deletes any Stop with the following attribute(s) </p>
        <form method="POST" action="stop.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <select name="attribute"> 
                <option value='stoppID'>*Stop ID</option>
                <option value='junctionName'>+*Junction Name</option>
                <option value='location'>*Location</option>
                <option value='direction'>*Direction</option>
            </select>
            <input type="text" name="value"><br><br>
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />
        <h2>Count Stops</h2>
        <form method="GET" action="stop.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples">
        </form>

        <hr />

        <h2>Display all Stops</h2>
        <form method="GET" action="stop.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Project and Select Stop</h2>
        <form method="GET" action="stop.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectTupleRequest" name="selectTupleRequest">

            <input type="checkbox" name="cStopID" value='stoppID' checked></input>Stop ID<br>
            <input type="checkbox" name="cJunction" value='junctionName' checked></input>Junction Name<br>
            <input type="checkbox" name="cLocation" value='location' checked></input>Location<br>
            <input type="checkbox" name="cDirection" value='direction' checked></input>Direction<br>
            <select name="attribute">
                <option value='stoppID'>Stop ID</option>
                <option value='junctionName'>Junction Name</option>
                <option value='location'>Location</option>
                <option value='direction'>Direction</option>
            </select>
            <input type="text" name="value"><br><br>
            <input type="submit" name="selectTuples"></p>
        </form>

        <hr />

        <h2>Add a Route to a Stop</h2>
        <form method="POST" action="stop.php">
        <input type="hidden" id="insertContainsQueryRequest" name="insertContainsQueryRequest">
            *Stop ID: <input type="text" name="insStop" required> <br /><br />
            +*Route ID: <input type="text" name="insRoute" required> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Display all Stops WITH Routes</h2>
        <form method="GET" action="stop.php">
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayContainsTuples"></p>
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
            echo "<br>Retrieved stop data:<br>";
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

            $stopTuple = array (
                ":bind1" => $_POST['insSID'],
                ":bind2" => $_POST['insJunction'],
                ":bind3" => $_POST['insLoc'],
                ":bind4" => $_POST['insDir'],
            );

            $allStopTuples = array (
                $stopTuple
            );
            
            executeBoundSQL("insert into stopp values (:bind1, :bind2, :bind3, :bind4)", $allStopTuples);
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

            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $command = "UPDATE stopp SET " . $newAttribute . " = '" . $newValue . "' WHERE " . $oldAttribute . " = '" . $oldValue . "'";
            executePlainSQL($command);
            OCICommit($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn;

            $value;
            if (isset($_POST['value'])) {
                $value = $_POST['value']; 
            } else {
                $value = 'NULL';
            }

            executePlainSQL("DELETE FROM stopp WHERE " . $_POST['attribute'] . " = '" . $_POST['value'] . "'");
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM stopp");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of Stops: " . $row[0] . "<br>";
            }
        }

        function handleDisplayRequest() {
            $result = executePlainSQL("SELECT * FROM stopp");
            $list = array("Stop ID", "Junction Name", "Location", "Direction");
            printResult($result, $list);
        }

        function handleDisplayContainsRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM contains");
            $list = array("Stop ID", "Route ID");
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
            if (isset($_GET['cStopID'])) {
                $command .= $_GET['cStopID'] . ", ";
                array_push($list, 'Stop ID');
            }
            if (isset($_GET['cJunction'])) {
                $command .= $_GET['cJunction'] . ", ";
                array_push($list, 'Junction Name');
            }
            if (isset($_GET['cLocation'])) {
                $command .= $_GET['cLocation'] . ", ";
                array_push($list, 'Location');
            }
            if (isset($_GET['cDirection'])) {
                $command .= $_GET['cDirection'] . ", ";
                array_push($list, 'Direction');
            }

            $command = substr($command, 0, strlen($command) - 2) . " ";
            $command .= "FROM stopp WHERE " . $_GET['attribute'] ;
            
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
