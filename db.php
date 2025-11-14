<?php
class DbConnection {
    private const USERNAME = "root";
    private const HOSTNAME = "localhost";
    private const PASSWORD = "";
    private const DB_NAME = "mytodo";

    private static ?PDO $pdo = null;
    private static ?DbConnection $connection = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): DbConnection {
        if (self::$connection === null) {
            self::$connection = new self();
        }
        return self::$connection;
    }

    public function connect(): PDO {
        if (self::$pdo === null) {

            $dsn = "mysql:host=" . self::HOSTNAME . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, self::USERNAME, self::PASSWORD, $options);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                die("Không thể kết nối cơ sở dữ liệu.");
            }
        }
        return self::$pdo;
    }
}

class DbHelper
{
	private PDO $pdo;
	public function __construct(){

		try {
            // Lấy đối tượng PDO duy nhất từ DbConnection Singleton
            $this->pdo = DbConnection::getConnection()->connect();
        } catch (PDOException $e) {
            // Nếu không thể kết nối, dừng chương trình
            die("Không thể khởi tạo DbHelper: " . $e->getMessage());
        }
    }
	
	
	
	private function executeStatement(string $sql, array $params)//: PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params); // Tự động ràng buộc và thực thi
            return $stmt;
        } catch (PDOException $e) {
            // Log lỗi, có thể throw lại hoặc trả về thông báo lỗi thân thiện
            // Trong môi trường thực tế, không nên hiển thị $sql và lỗi chi tiết ra cho người dùng.
            throw new PDOException("Lỗi thực thi truy vấn SQL: " . $e->getMessage() . " - SQL: " . $sql, (int)$e->getCode());
        }
    }

    public function select(string $sql, array $params = [], bool $fetchAll = true)//: mixed
    {
        $stmt = $this->executeStatement($sql, $params);
        
        if ($fetchAll) {
            return $stmt->fetchAll();
        }
        
        return $stmt->fetch();
    }

	public function execute($sql, array $params = [])// : int
	{		
		$stmt = $this->executeStatement($sql, $params);
        return $stmt->rowCount();
	}

	public function insert(string $sql, array $params = [])//: int
    {
        $this->execute($sql, $params);
        // Trả về ID của dòng cuối cùng được chèn
        return (int)$this->pdo->lastInsertId();
    }
	
	public function delete(string $sql, array $params = []): int
    {
        // Tái sử dụng phương thức execute đã có sẵn để thực thi câu lệnh
        $rowsAffected = $this->execute($sql, $params);
        
        return $rowsAffected;
    }
	
	public function update(string $sql, array $params = []): int
    {
        // Tái sử dụng phương thức execute đã có sẵn để thực thi câu lệnh
        $rowsAffected = $this->execute($sql, $params);
        
        return $rowsAffected;
    }
}
?>