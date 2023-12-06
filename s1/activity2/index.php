<?php
require_once 'templates/header.php';

$host = 'localhost';
$database = 'PHP_connect';
$user = 'root';
$password = '';

try {
    // Kết nối đến cơ sở dữ liệu MySQL
    $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password); // kết nối thông qua constructor
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    // thực hiện câu lệnh truy vấn Create table
    // $sqlCreateTable = "CREATE TABLE posts (
    //     id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    //     name varchar(100) NOT NULL,
    //     message varchar(200) NOT NULL
    //   );" ;

    // $result = $connection->query($sqlCreateTable);
 
    // kiểm tra phương thức của form 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['message'])) {
        // Lấy dữ liệu từ $_POST
        $username = $_POST['username']; // lấy dữ liệu từ url
        $message = $_POST['message'];

        // Thực hiện truy vấn INSERT để thêm đữ liệu vào bảng
        $query = "INSERT INTO posts (name, message) VALUES (?, ?)"; //tạo câu lệnhh truy vấn
        $stmt = $connection->prepare($query); // chuẩn bị câu truy vấn
        $stmt->bindParam(1, $username); // Liên kết một tham số trong truy vấn với một biến -> liên kết tham số thứ 1 = $username
        $stmt->bindParam(2, $message); //Liên kết một tham số trong truy vấn với một biến. -> liên kết tham số thứ 2 = $mesage
        $stmt->execute();// thực thi câu lệnh truy vấn "prepare"
    }

    // Thực hiện truy vấn SELECT để lấy tất cả bài viết từ cơ sở dữ liệu
    $query = "SELECT * FROM posts"; // câu lệnh truy vấn
    $stmt = $connection->query($query); // thực hiện câu lệnh truy vấn
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);// lấy kết quả sau khhi truy vấn được trả về một mảng kết hợp bằng fetchAll

}
catch (PDOException $e) { 
    echo 'Lỗi: ' . $e->getMessage(); // in ra lỗi kết nối
}

foreach ($posts as $post => $value) { // chạy vòng lặp để lấy giá trị trong mảng kết hợp
?>
    <div class="card">
        <div class="card-header">
            <span><?php // display the value of username for this post
             echo $value['name'] ?></span>
        </div>
        <div class="card-body">
            <p class="card-text"><?php // display the message for this post 
             echo $value['message']?></p>
        </div>
    </div>
    <hr>
<?php
}

?>

<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
        </div>
    </div>

    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
    </div>
    <div class="d-grid">