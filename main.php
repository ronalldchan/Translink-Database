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
        <h2>Main Page</h2>
        <p>This is the main page of the project, use buttons to navigate to actions</p>
    
        <hr />

        <div class="button-group">
            <a href = "bus.php"><button class="button">Bus</button></a>
            <a href = "skytrain.php"><button class="button">Skytrain</button></a>
            <a href = "driver.php"><button class="button">Driver</button></a> <br><br>
            <a href = "junction.php"><button class="button">Junctions</button></a>
            <a href = "garage.php"><button class="button">Bike Garages</button></a><br><br>
            <a href = "customer.php"><button class="button">Customer</button></a>
            <a href = "route.php"><button class="button">Route</button></a>
            <a href = "stop.php"><button class="button">Stop</button></a>
        </div>
        
        <form method="POST" action="main.php"> 
            <!-- POST is used to send data to server to create/update a resource -->
            <!-- action is where to send the data to-->
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP
        // system('bookbiz.sql');
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

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                }
                disconnectFromDB();
            }
        }

		if (isset($_POST['reset'])) {
            handlePOSTRequest();
        }
		?>
	</body>
</html>
