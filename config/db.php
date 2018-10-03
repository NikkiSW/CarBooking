<?php
class Database {

    private $mysqli;

    /**
     * Creates the mysql connection.
     * Kills the script on connection or database errors.
     * 
     * @return boolean
     */
    public function __construct(){
			$this->host        = "localhost";
			$this->username    = "root";
			$this->password    = "";
			$this->database    = "car_booking";

			$this->mysqli = new mysqli($this->host, $this->username, $this->password)
				OR die("There was a problem connecting to the database.");

			// check connection
			if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
			}

			$this->mysqli->select_db($this->database);

			if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
			}

      return true;
    }

    /**
     * On error returns an array with the error code.
     * On success returns an array with multiple mysql data.
     * 
     * @param string $query
     * @return array
     */
    public function query($query) {
			// array returned, includes a success boolean
			$return = array();

			if (!$result = $this->mysqli->query($query)) {
					$return['success'] = false;
					$return['error'] = $this->mysqli->error;

					return $result;
			}
	
			$return['success'] = true;
			$return['affected_rows'] = $this->mysqli->affected_rows;
			$return['insert_id'] = $this->mysqli->insert_id;

			if ($this->mysqli->insert_id == 0 && isset($result->num_rows)) {
				$return['count'] = $result->num_rows;
				$return['rows'] = array();
				
				//fetch associative array
				while ($row = $result->fetch_assoc()) {
					$return['rows'][] = $row;
				}

				// free result set
				$result->close();
			}

      return $return;
    }

    /**
     * Automatically closes the mysql connection
     * at the end of the program.
     */
    public function __destruct() {
      $this->mysqli->close()
        OR die("There was a problem disconnecting from the database.");
    }
}
?>