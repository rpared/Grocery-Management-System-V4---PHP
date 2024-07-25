<?php

class Database_connection {
    //ROGER's AZURE DATABASE 
    // private $dsn = 'mysql:host=rogersql.mysql.database.azure.com;dbname=db_vegan_heaven;sslmode=require';
    // private $username = 'mysql';
    // private $password = 'ASK DBADMIN FOR THIS!!!';

    //LOCAL DATABASE (run .SQL query attached in the database folder to create it)
    // $dsn = 'mysql:host=localhost; dbname=db_fitform';//ROGER's Data Source Name
    private $dsn = 'mysql:host=localhost;dbname=db_vegan_heaven';//Kirill's Data Source Name
    private $username = 'root';
    // $password = '1234';//ROGER's MySQL password
    private $password = '7400';//Kirill's MySQL password




    private $ssl_cert = './SSLcert/MicrosoftRSARootCertificateAuthority2017.crt';
    private $options;
    private $db;



    public function __construct() {
        $this->options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => $this->ssl_cert,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        );

        try {
            $this->db = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Error connecting to database ☹️: $error_message </p>";
            exit();
        }
    }

    public function getConnection() {
        return $this->db;
    }
}

?>
