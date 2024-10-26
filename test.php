<?php
function generateRandomArray($n, $a, $b, $smallestNumber, $biggestNumber)
{
    $numbers = [];
    $currentTotal = 0;

    try {
        for ($i = 0; $i < $n; $i++) {
            do {
                $number = random_int($smallestNumber, $biggestNumber);
            } while ($number + $currentTotal > $b || $number + $currentTotal < $a || $number < $smallestNumber || $number > $biggestNumber);
            $numbers[] = $number;
            $currentTotal += $number;
        }
    } catch (Exception $e) {
        return [];
    }
    return $numbers;
}


if (isset($_REQUEST['questionCount']) && isset($_REQUEST['timeLimit']) && isset($_REQUEST['numberA']) && isset($_REQUEST['numberB']) && isset($_REQUEST['smallestnumber']) && isset($_REQUEST['bigestnumber'])) {
    $questionCount = $_REQUEST['questionCount'];
    $timeLimit = $_REQUEST['timeLimit'];
    $numberA = $_REQUEST['numberA'];
    $numberB = $_REQUEST['numberB'];
    $smallestNumber = $_REQUEST['smallestnumber'];
    $biggestNumber = $_REQUEST['bigestnumber'];
    if ($smallestNumber > $biggestNumber || $smallestNumber >= 0) {
        echo '<script>alert("Kiểm tra lại giới hạn số");</script>';
        header("Location: index.php?questionCount=10&timeLimit=3&numberA=0&numberB=10&smallestnumber=-10&bigestnumber=10");
        exit();
    }
    $numberList = generateRandomArray($questionCount, $numberA, $numberB, $smallestNumber, $biggestNumber);
} else {
    header("Location: index.php?questionCount=10&timeLimit=3&numberA=0&numberB=10&smallestnumber=-10&bigestnumber=10");
    exit();
}


?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Finger Math</title>

    <!-- Thêm Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thêm jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Thêm style.css -->

    <link href="style.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #FFB5A7;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            top: 0;
            z-index: 1000;
        }

        .avatar {
            height: 120px;
            border-radius: 50%;
        }

        .title {
            margin-left: 80vh;
            flex-grow: 1;
        }

        .title h1 {
            font-weight: bold;
            font-size: 2em;
        }

        .title h2 {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5em;
            margin-left: 2.5em;
        }

        .number-display {
            font-size: 10em;
            color: red;
            margin: 20px 0;
            text-align: center;
        }

        .controls {
            display: flex;
            justify-content: space-around;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .controls .input-group {
            width: 30%;
            height: auto;
        }

        .controls button {
            font-size: 1em;
            padding: 10px 20px;
            cursor: pointer;
            width: 20%;
            height: auto;
        }

        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 20px;
            background-color: #FCD5CE;
        }

        .progress-column {
            position: fixed;
            left: 20px;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
        }

        .circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #6C757D;
            /* Màu xám cho câu hỏi chưa trả lời */
            margin: 10px 0;
            /* Khoảng cách giữa các hình tròn */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .circle.correct {
            background-color: green;
            /* Màu xanh cho câu trả lời đúng */
        }

        .circle.incorrect {
            background-color: red;
            /* Màu đỏ cho câu trả lời sai */
        }

        /* Định dạng cho menu bên trái */
        .menu {
            position: fixed;
            top: 0;
            left: -250px;
            /* Ẩn menu bên trái */
            width: 250px;
            height: 100%;
            background-color: #a49de1;
            transition: left 0.3s ease;
            z-index: 1000;
            padding: 20px;
        }

        .menu.active {
            left: 0;
            /* Hiển thị menu */
        }

        .menu h3 {
            margin-top: 0;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
        }

        .menu li {
            margin: 10px 0;
            cursor: pointer;
        }

        .hamburger {
            cursor: pointer;
            font-size: 30px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nhập Thông Tin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" type="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="questionCount">Số lượng câu hỏi <br>(Số lượng số xuất hiện)</label>
                                <input type="number" class="form-control" id="questionCount" name="questionCount" value="<?php echo $_REQUEST['questionCount'] ?>"
                                    placeholder=" Nhập số lượng">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="timeLimit">Thời gian chuyển câu hỏi (giây)</label>
                                <input type="number" class="form-control" id="timeLimit" name="timeLimit" value="<?php echo $_REQUEST['timeLimit'] ?>"
                                    placeholder=" Nhập thời gian">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="numberA">Giá trị bắt đầu đáp án</label>
                                <input type="number" class="form-control" id="numberA" placeholder="Nhập số" name="numberA" value="<?php echo $_REQUEST['numberA'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="numberB">Giá trị kết thúc đáp án</label>
                                <input type="number" class="form-control" id="numberB" placeholder="Nhập số" name="numberB" value="<?php echo $_REQUEST['numberB'] ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="smallestnumber">Số bé nhất</label>
                                <input type="number" class="form-control" id="smallestnumber" placeholder="Nhập số" name="smallestnumber" value="<?php echo $_REQUEST['smallestnumber'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="bigestnumber">Số lớn nhất</label>
                                <input type="number" class="form-control" id="bigestnumber" placeholder="Nhập số" name="bigestnumber" value="<?php echo $_REQUEST['bigestnumber'] ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="header">
        <div class="hamburger" id="hamburger">☰</div>
        <div class="title">
            <h1>Toán Finger Math</h1>
            <h2>Cùng cô Ánh</h2>
        </div>
        <img src="img/ngocanh.jpg" alt="Avatar" class="avatar">
    </div>

    <!-- Menu bên trái -->
    <div class="menu" id="leftMenu">
        <h3>Menu</h3>
        <ul>
            <li>Trang chủ</li>
            <li>Toán Finger Math</li>
            <li>Trò chơi Đoán Hình</li>
            <li>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="setup">
                    Cài đặt ngẫu nhiên
                </button>
            </li>
        </ul>
    </div>

    

    <!-- Audio -->
    <audio id="startgame" src="music/start.wav"></audio>
    <audio id="correctSound" src="music/win.mp3"></audio>
    <audio id="incorrectSound" src="music/lose.mp3"></audio>


    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        
        function showSticker(isCorrect) {
            var sticker = document.getElementById('sticker');
            var sound = isCorrect ? document.getElementById('correctSound') : document.getElementById('incorrectSound');

            if (isCorrect) {
                sticker.innerHTML = '<iframe src="https://giphy.com/embed/1xNDVX4DV6B5vo6unw" width="240" height="240" style="border: none;" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/molangofficialpage-game-dance-happy-1xNDVX4DV6B5vo6unw">via GIPHY</a></p>';
            } else {
                sticker.innerHTML = '<iframe src="https://giphy.com/embed/3o6Zt481isNVuQI1l6" width="240" height="240" style="border: none;" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/3o6Zt481isNVuQI1l6">via GIPHY</a></p>';
            }

            sound.play();
        }


        // Xử lý sự kiện nhấp chuột vào hamburger menu
        document.getElementById('hamburger').addEventListener('click', function() {
            const menu = document.getElementById('leftMenu');
            menu.classList.toggle('active'); // Thay đổi trạng thái menu
        });

        // Đóng menu khi nhấp ra ngoài
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('leftMenu');
            const hamburger = document.getElementById('hamburger');

            // Kiểm tra nếu nhấp bên ngoài menu và hamburger
            if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
                menu.classList.remove('active'); // Đóng menu
            }
        });

        document.getElementById('setup').addEventListener('click', function() {
            $('#myModal').modal({
                backdrop: false
            });
        });
        // câu hỏi kế tiếp
        document.getElementById('nextButton').addEventListener('click', function() {
            location.reload(); // Chuyển trang lại để tạo ra câu h��i mới
        });

        // Xử lý nút enter
        document.getElementById('answerInput').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('checkButton').click();
            }
        });

    </script>
</body>

</html>