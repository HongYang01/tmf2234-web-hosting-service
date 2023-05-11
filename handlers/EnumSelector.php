<?php

/**
 * EnumSelector is a class that renders an HTML select element populated with enum values from a database table column.
 *
 * Usage:
 * 1. Include the class file: require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/EnumSelector.php");
 * 2. Create an instance of the class: $EnumSelector = new EnumSelector($table, $column, $conn);
 * 3. Render the select element: $EnumSelector->render($prod_category);
 */

class EnumSelector
{
    private $table;
    private $column;
    private $conn;

    /**
     * EnumSelector constructor.
     * @param string $table The name of the database table.
     * @param string $column The name of the column containing enum values.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($table, $column, $conn)
    {
        $this->table = $table;
        $this->column = $column;
        $this->conn = $conn;
    }

    /**
     * Retrieves all enum values from the specified table column.
     * @return array An array containing all the enum values.
     */
    private function getAllEnumValue()
    {
        $allEnumValue = array();

        // Execute the SHOW COLUMNS statement to get column information
        $query = "SHOW COLUMNS FROM {$this->table} LIKE '{$this->column}'";
        $result = mysqli_query($this->conn, $query);

        if ($row = mysqli_fetch_array($result)) {
            // Parse the enum values from the column type
            // use 5 to remove the starting of "enum("
            // use -6 to remove the white space behind
            $allEnumValue = explode(",", str_replace("'", "", substr($row['Type'], 5, (strlen($row['Type']) - 6))));
        }

        return $allEnumValue;
    }

    /**
     * Renders an HTML select element with options populated from enum values.
     * @param string $selectedEnum The currently selected enum value.
     */
    public function render($selectedEnum)
    {
        $allEnumValue = $this->getAllEnumValue();

        foreach ($allEnumValue as $temp) {
            // Skip empty values
            if (!empty(trim($temp))) {
                if ($temp == $selectedEnum) {
                    echo "<option value='$temp' selected>$temp</option>";
                } else {
                    echo "<option value='$temp'>$temp</option>";
                }
            }
        }
    }
}
