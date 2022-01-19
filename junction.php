<html>
    <head>
        <title>CPSC 304 Project: TransLink System</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <h1>CPSC 304 Project: TransLink System</h1>
        <div class="topnav">
            <a class="active" href="main.php">Home</a>
            <a href="about.html">About</a>
        </div>
        <h2>Junction Page</h2>
        <p>This is the Junction page of the project with actions relating to Junction.</p>
        
        <hr />

        <h2>Legend:</h2>
        <p>+ = Must come from pre-existing value<br>* = Required data</p>

        <form method="POST" action="main.php"> 
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <input type="submit" value="Reset" name="reset">
        </form>

        <hr />

        <h2>Insert a new Junction</h2>

        <form method="POST" action="junction.php"> <!--refresh page when submitted-->
            <h3>Junction Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            +*Junction Name: <input type="text" name="insJunction"> <br /><br />
            *Location: <input type="text" name="insLocation"> <br /><br />
            *Isskytrain? (y or n): <input type="text" name="insskytrain"> <br /><br />
            *Num Buses: <input type="text" name="insBuses"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Update Attribute of a Junction</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all susloop tuples with old attribute with new attribute.
        </p>

        <form method="POST" action="junction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            <select name="oldAttribute"> 
                <option value='junctionName'> +*Junction Name </option>
                <option value='isSkytrain'> +*isSkytrain (y or n) </option>
                <option value='num_bus'> *Num Buses </option>
            </select>
            <input type="text" name="oldAttributeValue"> <br /><br />
            <select name="newAttribute"> 
                <option value='num_bus'> *Num Buses </option>
            </select>
            <input type="text" name="newAttributeValue"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Delete a Junction</h2>
        <p>Deletes any Junction with the following attribute(s) </p>
        <form method="POST" action="junction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <select name="attribute"> 
                <option value='junctionName'> +*Junction Name </option>
                <option value='num_bus'> *Num Buses </option>
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
        <h2>Count Junctions</h2>
        <form method="GET" action="junction.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples">
        </form>

        <hr />

        <h2>Display all Junctions</h2>
        <form method="GET" action="junction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Select Junction</h2>
        <form method="GET" action="junction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectTupleRequest" name="selectTupleRequest">
            <select name="attribute">
                <option value='junctionName'> Junction Name </option>
                <option value='location'> Location </option>
                <option value='num_bus'> Num Buses </option>
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

        <h2>Select Junction By location</h2>
        <p>select criteria based on the location of a junction<br>
            Select nothing to get all of the junctions for a given location
        </p>
        <form method="GET" action="junction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectHavingRequest" name="selectHavingRequest">
            Is Skytrain? (y or n): <input type="text" name="isSkytrain"> <br /><br />
            Number of Buses: 
            <select name="comparison">
                <option value='='> = </option>
                <option value='<='> <= </option>
                <option value='>='> >= </option>
                <option value='<'> < </option>
                <option value='>'> > </option>
            </select> 
            <input type="text" name="numBus"> <br /><br />
            <input type="submit" value="Select" name="selectHavingTuples"></p>
        </form>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP
        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function handleSelectHavingRequest() {
            global $db_conn;

            $valuenumbus;
            $list = array();
            if (isset($_GET['cisSkytrainID'])) {
                array_push($list, 'Garage ID');
            }
            if (isset($_GET['numBus'])) {
                array_push($list, 'Junction Name');
            }

            if ($_GET['numBus'] != NULL) {
                $valuenumbus = $_GET['numBus'];
            } else {
                if ($_GET['isSkytrain'] == NULL) {
                    $result = executePlainSQL("SELECT junction.location, sum( bus_loop.num_bus)
                                                FROM junction, bus_loop
                                                where junction.junctionName = bus_loop.junctionName
                                                group by junction.location");
                printSelect($result, $list);   
                     $result = executePlainSQL("SELECT junction.location, sum( skytrain_station.num_bus)
                                                FROM junction, skytrain_station
                                                where junction.junctionName = skytrain_station.junctionName
                                                group by junction.location");
                printSelect($result, $list);   
                     return;
                }
            }
            if ($_GET['isSkytrain'] == NULL) {
                $result = executePlainSQL("SELECT junction.location, sum( bus_loop.num_bus)
                                                FROM junction, bus_loop
                                                where junction.junctionName = bus_loop.junctionName
                                                group by junction.location
                                                having sum(bus_loop.num_bus)". $_GET['comparison'] . $valuenumbus);
                 printSelect($result, $list);   
                     $result = executePlainSQL("SELECT junction.location, sum( skytrain_station.num_bus)
                                                FROM junction, skytrain_station
                                                where junction.junctionName = skytrain_station.junctionName
                                                group by junction.location
                                                having sum(skytrain_station.num_bus)". $_GET['comparison'] . $valuenumbus);
                printSelect($result, $list);   
                     return;
            }
            if ($_GET['numBus'] == NULL) {
                if ($_GET['isSkytrain'] == 'y') {
                    $result = executePlainSQL("SELECT junction.location, sum( skytrain_station.num_bus)
                                                FROM junction, skytrain_station
                                                where junction.junctionName = skytrain_station.junctionName
                                                group by junction.location");
                printSelect($result, $list);   
                } else {
                    $result = executePlainSQL("SELECT junction.location, sum( bus_loop.num_bus)
                                                FROM junction, bus_loop
                                                where junction.junctionName = bus_loop.junctionName
                                                group by junction.location");
                printSelect($result, $list);   
                }
                return;
            }

            if ($_GET['isSkytrain'] == 'y') {
                $result = executePlainSQL("SELECT junction.location, sum( skytrain_station.num_bus)
                                            FROM junction, skytrain_station
                                            where junction.junctionName = skytrain_station.junctionName
                                            group by junction.location
                                            having sum(skytrain_station.num_bus)". $_GET['comparison'] . $valuenumbus);
                printSelect($result, $list);   
            } else {
                $result = executePlainSQL("SELECT junction.location, sum( bus_loop.num_bus)
                                            FROM junction, bus_loop
                                            where junction.junctionName = bus_loop.junctionName
                                            group by junction.location
                                            having sum(bus_loop.num_bus)". $_GET['comparison'] . $valuenumbus);
                printSelect($result, $list);   
            }
        }

        function printSelect($result, $head) { //prints results from a select statement
            echo "<br>Retrieved bus data:<br>";
            echo "<table style='width:50%' border=1>";
            echo "<tr><th>Location</th> <th>Number of Buses</th>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1];
            }

            echo "</table>";
        }

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

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved Junction data:<br>";
            echo "<table style='width:50%' border=1>";
            echo "<tr><th>Junction Name</th> <th>Location</th> <th>isSkytrain?</th> <th>Num Buses</th>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>". $row[3];
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

        function handleUpdateRequest() {
            global $db_conn;

            $JunctionAttributes = array(
                'junctionName', 'location', "isSkytrain"
            );

            $Attributes = array('junctionName', 'num_bus');


            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $command;
            // will only update within same table, will be easier to code for
            if ($oldAttribute == 'junctionName') {
                $command = "UPDATE bus_loop SET num_bus = " . $newValue . " WHERE junctionName = '" . $oldValue . "'";
                executePlainSQL($command);
                $command = "UPDATE skytrain_station SET num_bus = " . $newValue . " WHERE junctionName = '" . $oldValue . "'";
                executePlainSQL($command);
            } else if ($oldAttribute == 'isSkytrain') {
                if ($oldValue == 'y') {
                    $command = "UPDATE skytrain_station SET num_bus = " . $newValue;
                    executePlainSQL($command);
                } else if ($oldValue == 'n') {
                    $command = "UPDATE bus_loop SET num_bus = " . $newValue;
                    executePlainSQL($command);
                }
            } else if ($oldAttribute == 'num_bus') {
                $command = "UPDATE bus_loop SET num_bus = " . $newValue . " WHERE num_bus = " . $oldValue;
                executePlainSQL($command);
                $command = "UPDATE skytrain_station SET num_bus = " . $newValue . " WHERE num_bus = " . $oldValue;
                executePlainSQL($command);
            } else {
                echo("Selected attributes are not from same table and are not compatible");
            }
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            runSQLFile('main.sql');
            OCICommit($db_conn);
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

        function handleInsertRequest() {
            global $db_conn;
            $junction;
            if (isset($_POST['insJunction'])) {
                $junction = $_POST['insJunction'];
            } else {
                $junction = "null";
            }


            $junctionTuple = array (
                ":bind1" => $_POST['insJunction'],
                ":bind2" => $_POST['insLocation'],
                ":bind3" => $_POST['insskytrain'],
            );

            $busloopTuple = array(
                ":bind1" => $_POST['insJunction'],
                ":bind2" => $_POST['insBuses'],
            );
            $skytrainTuple = array(
                ":bind1" => $_POST['insJunction'],
                ":bind2" => $_POST['insBuses'],
            );

            $allJunctionTuples = array (
                $junctionTuple
            );

            $allBusloopTuples = array(
                $busloopTuple
            );

            $allSkytrainTuples = array(
                $skytrainTuple
            );

            if ($_POST['insskytrain'] == "n") {
                executeBoundSQL("insert into junction values (:bind1, :bind2, 0)", $allJunctionTuples);
                executeBoundSQL("insert into bus_loop values (:bind1, :bind2)", $allBusloopTuples);
            } else if ($_POST['insskytrain'] == "y") {
                executeBoundSQL("insert into junction values (:bind1, :bind2, 1)", $allJunctionTuples);
                executeBoundSQL("insert into skytrain_station values (:bind1, :bind2)", $allSkytrainTuples);
            }
            OCICommit($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn;
            global $result;

            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $value;
            if (isset($_POST['value'])) {
                $value = $_POST['value']; 
            } else {
                $value = 'NULL';
            }

            if ($_POST['attribute'] == 'junctionName') {
                    executePlainSQL("DELETE from bus_loop where junctionName = '" . $value . "'");
                    executePlainSQL("DELETE from junction where junctionName = '" . $value . "'");
                    executePlainSQL("DELETE from skytrain_station where junctionName = '" . $value . "'");
                    executePlainSQL("DELETE from junction where junctionName = '" . $value . "'");
            } else if ($_POST['attribute'] == 'num_bus') {
                $result1 = executePlainSQL("SELECT junctionName from bus_loop where " . $_POST['attribute'] . $_POST['comparison'] . $value);
                $result2 = executePlainSQL("SELECT junctionName from skytrain_station where " . $_POST['attribute'] . $_POST['comparison'] . $value);
                executePlainSQL('delete from bus_loop where ' . $_POST['attribute'] . $_POST['comparison'] . $value);
                executePlainSQL('delete from skytrain_station where ' . $_POST['attribute'] . $_POST['comparison'] . $value);
                while ($row1 = OCI_Fetch_Array($result1, OCI_BOTH) || $row2 = OCI_Fetch_Array($result2, OCI_BOTH)) {
                    executePlainSQL("delete from junction where junctionName = '" . $row1['JUNCTIONNAME'] . "' or junctionName = '" . $row2['JUNCTIONNAME']. "'");
                }
            }

            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result1 = executePlainSQL("SELECT Count(*) FROM junction");

            if (($row1 = oci_fetch_row($result1)) == false) {
                return;
            }
            echo "<br> The number of tuples in junction: " . $row1[0] . "<br>";
        }

        function handleDisplayRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT junction.junctionName, junction.location, junction.isSkytrain, bus_loop.num_bus
                                        FROM junction, bus_loop
                                        where junction.junctionName = bus_loop.junctionName");
            echo "<br> Here are bus loops <br>";
            printResult($result);
            $result = executePlainSQL("SELECT junction.junctionName, junction.location, junction.isSkytrain, skytrain_station.num_bus
                                        FROM junction, skytrain_station
                                        where junction.junctionName = skytrain_station.junctionName");
            echo "<br> Here are skytrains stations <br>";
            printResult($result);
        }

        function handleSelectRequest() {
            global $db_conn;

            $intAttributes = array('Num Buses');
            $value;

            if (in_array($_GET['value'], $intAttributes)) {
                $value = $_GET['value'];
            } else {
                $value = "'" . $_GET['value'] . "'";
            }

            $result = executePlainSQL("SELECT *
                                FROM (SELECT junction.junctionName, junction.location, junction.isSkytrain, bus_loop.num_bus
                                        FROM junction, bus_loop
                                        where junction.junctionName = bus_loop.junctionName)
                                WHERE " . $_GET['attribute'] . $_GET['comparison'] . $value);
            printResult($result);
            $result = executePlainSQL("SELECT *
                                FROM (SELECT junction.junctionName, junction.location, junction.isSkytrain, skytrain_station.num_bus
                                        FROM junction, skytrain_station
                                        where junction.junctionName = skytrain_station.junctionName)
                                WHERE " . $_GET['attribute'] . $_GET['comparison'] . $value);
            printResult($result);
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
                if (array_key_exists('selectHavingTuples', $_GET)) {
                    handleSelectHavingRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest']) || isset($_GET['selectTupleRequest']) || isset($_GET['selectHavingRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>
