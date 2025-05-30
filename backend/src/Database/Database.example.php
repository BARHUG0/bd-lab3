
<?php

    class Database
    {
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        public function __construct()
        {
            $this->host     = getenv('DB_HOST');
            $this->db_name  = getenv('DB_NAME');
            $this->username = getenv('DB_USER');
            $this->password = getenv('DB_PASSWORD');
        }

        public function getConnection()
        {
            $this->conn = null;
            try {
                $this->conn = new PDO(
                    "pgsql:host={$this->host};dbname={$this->db_name}",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Error de conexión: " . $exception->getMessage();
            }

            return $this->conn;
        }
}
