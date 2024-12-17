
<?php
        $servername = 'localhost';
        $username = "root";
        $password = "";
        $dbname = "tech_trove";
        // $servername = 'localhost';
        // $username = "alvin.appiah";
        // $password = "\$\$HaippaWebDev\$\$";
        // $dbname = "webtech_fall2024_alvin_appiah";
        //create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        //Check connection
        if ($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }
        //echo "Connected Succesfully";



    ?>

