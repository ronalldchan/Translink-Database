<html>
    <head>
        <title>CPSC 304 Project: TransLink System</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <h1>CPSC 304 Project: TransLink System</h1>
        <div class="topnav">
            <a class="active" href="main.php">Home</a>
            <a href="#news">News</a>
            <a href="#contact">Contact</a>
            <a href="#about">About</a>
        </div>
        <h2>Busloop Page</h2>
        <p>This is the busloop page of the project with actions relating to busloop.</p>
        
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

        <h2>Insert a new Busloop</h2>

        <form method="POST" action="busloop.php"> <!--refresh page when submitted-->
            <h3>Junction Data</h3>
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            +*Junction Name: <input type="text" name="insJunction"> <br /><br />
            *Location: <input type="text" name="insLocation"> <br /><br />
            <h3>Busloop Data</h3>
            *Num Buses: <input type="text" name="insBuses"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>



        <hr />

        <h2>Update Attribute of a Busloop</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything. <br>
            Will update all susloop tuples with old attribute with new attribute.
        </p>

        <form method="POST" action="busloop.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            <select name="oldAttribute"> 
                <option value='junctionName'> +*Junction Name </option>
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

        <h2>Delete a Busloop</h2>
        <p>Deletes any busloop with the following attribute(s) </p>
        <form method="POST" action="busloop.php"> <!--refresh page when submitted-->
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
        <h2>Count Busloops</h2>
        <form method="GET" action="busloop.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples">
        </form>

        <hr />

        <h2>Display all Busloops</h2>
        <form method="GET" action="busloop.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Select Busloop</h2>
        <form method="GET" action="busloop.php"> <!--refresh page when submitted-->
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

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved busloop data:<br>";
            echo "<table style='width:50%' border=1>";
            echo "<tr><th>Junction Name</th> <th>Location</th> <th>Num Buses</th>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                // echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>";
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_dynnwa", "a73089518", "dbhost.students.cs.ubc.ca:1522/stu");

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
                'junctionName', 'location',
            );

            $busloopAttributes = array('junctionName','num_bus');


            $oldAttribute = $_POST['oldAttribute'];
            $oldValue = $_POST['oldAttributeValue'];
            $newAttribute = $_POST['newAttribute'];
            $newValue = $_POST['newAttributeValue'];

            $command;
            // will only update within same table, will be easier to code for
            if (in_array($oldAttribute, $JunctionAttributes) and in_array($newAttribute, $JunctionAttributes)) {
                $command = "UPDATE junction SET " . $newAttribute . " = ";
                $command .= "'".$newValue. "'";
                $command .= " WHERE " . $oldAttribute . " = ";
                $command .= "'".$oldValue."'";
                executePlainSQL($command);
            } else if (in_array($oldAttribute, $JunctionAttributes) and in_array($newAttribute, $busloopAttributes)) {
                $command = "UPDATE bus_loop SET " . $newAttribute . " = " . $newValue . " WHERE " . $oldAttribute . " = ";
                if ($oldAttribute == 'num_bus') {
                    $command .=  $oldValue;
                } else {
                    $command .= "'" . $oldValue . "'";
                }
                executePlainSQL($command);
            } else {
                echo("Selected attributes are not from same table and are not compatible");
            }
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop and create table
            echo "<br> creating new table <br>";
            runSQLFile('main.sql');
            echo "<br> created new table <br>";
        
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

            //Getting the values from user and insert data into the table

            $junction;
            if (isset($_POST['insJunction'])) {
                $junction = $_POST['insJunction'];
            } else {
                $junction = "null";
            }


            $junctionTuple = array (
                ":bind1" => $_POST['insJunction'],
                ":bind2" => $_POST['insLocation'],
            );

            $busloopTuple = array(
                ":bind1" => $_POST['insJunction'],
                ":bind2" => $_POST['insBuses'],
            );

            $allJunctionTuples = array (
                $junctionTuple
            );

            $allBusloopTuples = array(
                $busloopTuple
            );
                // the 0 below is because anything inputted of this page is gonna be a busloop and not a skytrain
            executeBoundSQL("insert into junction values (:bind1, :bind2, 0)", $allJunctionTuples);
            executeBoundSQL("insert into bus_loop values (:bind1, :bind2)", $allBusloopTuples);
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
                $result = executePlainSQL("SELECT junctionName from bus_loop where junctionName = '" . $value . "'");
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    executePlainSQL("DELETE from bus_loop where junctionName = '" . $row['JUNCTIONNAME'] . "'");
                    executePlainSQL("DELETE from junction where junctionName = '" . $row['JUNCTIONNAME'] . "'");
                }
            } else if ($_POST['attribute'] == 'num_bus') {
                    executePlainSQL('delete from bus_loop where ' . $_POST['attribute'] . $_POST['comparison'] . $value);
                }

            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM bus_loop");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in busloop: " . $row[0] . "<br>";
            }
        }

        function handleDisplayRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT junction.junctionName, junction.location, bus_loop.num_bus
                                        FROM junction, bus_loop
                                        where junction.junctionName = bus_loop.junctionName");
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
                                FROM (SELECT junction.junctionName, junction.location, bus_loop.num_bus
                                        FROM junction, bus_loop
                                        where junction.junctionName = bus_loop.junctionName)
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
