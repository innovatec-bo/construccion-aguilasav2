<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateLocalDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:update-from-production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createBK();
        return 0;
    }

    public function createBK() : void
    {
        $userName = "toqueelt_serebo2";
        $password = "EC?693W3C?pv";
        $databaseName = "toqueelt_serebo2";
        // Get connection object and set the charset
        $conn = mysqli_connect('toqueeltimbre.com', $userName, $password, $databaseName);
        $conn->set_charset("utf8");
        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
        $sqlScript = "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS = 0;";
        foreach ($tables as $table)
        {
            // Prepare SQLScript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            $sqlScript .= "\n\nDROP TABLE IF EXISTS `$table`;\n". $row[1] . ";\n\n";
            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);
            $columnCount = mysqli_num_fields($result);
            // Prepare SQLScript for dumping data for each table
            $sqlScript .= "BEGIN;\n";
            for ($i = 0; $i < $columnCount; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO `$table` VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $row[$j] = $row[$j];
                        if (isset($row[$j])) {
                            $sqlScript .= "'".$conn->real_escape_string($row[$j])."'";
                        } else {
                            $sqlScript .= 'NULL';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }

            $sqlScript .= "COMMIT;\n";
        }

        if (!empty($sqlScript)) {
            $sqlScript .="\nSET FOREIGN_KEY_CHECKS = 1;\n\n";
            $triggers = array();
            $sql = "show TRIGGERS;";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_row($result))
            {
                $triggers[] = $row[0];
            }

            foreach ($triggers as $trigger)
            {
                $query = "SHOW CREATE TRIGGER $trigger";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($result);
                //Remove 'definer' from triggers
                $createTrigger = str_replace("DEFINER=`root`@`localhost`","",$row[2]);
                $createTrigger = str_replace("DEFINER=`thepo007`@`localhost`","",$createTrigger);
                $sqlScript .= "DROP TRIGGER IF EXISTS `$trigger`;\ndelimiter ;;\n".$createTrigger."\n;;\ndelimiter ;\n\n";
            }

            // Save the SQL script to a backup file
            $this->_sqlBackupsFullPath = storage_path('backup.sql');// $this->_backupPath.$this->_dataBaseName . '_backup.sql';
            $fileHandler = fopen($this->_sqlBackupsFullPath, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);

            // $this->createZip();
            // $this->_downloadBackUps();
            // $this->_sendBackups();
            // $this->_deleteCurrentBackUps();
        }
    }

    private function _deleteCurrentBackUps() : void
    {
        if($this->_deleteSqlFile)
        {
            //database
            unlink($this->_sqlBackupsFullPath);
            //database and files
            // unlink($this->_zipFileFullPath);
//            echo"<pre>";var_dump($this->_sqlBackupsFullPath,$this->_zipFileFullPath);exit;
        }
    }
}
