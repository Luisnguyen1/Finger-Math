<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Image</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
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
            width: 100%;
        }

        .avatar {
            height: 80px;
            border-radius: 50%;
        }

        .title {
            flex-grow: 1;
            text-align: center;
        }

        .title h1 {
            font-weight: bold;
            font-size: 2em;
        }

        .title h2 {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5em;
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

        .menu {
            position: fixed;
            top: 0;
            left: -250px; /* Initially hide the menu */
            width: 250px;
            height: 100%;
            background-color: #FFB5A7;
            z-index: 1000;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: left 0.3s ease; /* Smooth transition */
            display: flex;
            flex-direction: column;
            align-items: left; /* Center the content horizontally */
        }

        .menu.active {
            left: 0; /* Show the menu when active */
        }

        .menu h3 {
            margin-top: 0;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
            width: 100%; /* Ensure the list takes full width */
        }

        .menu li {
            margin: 10px 0;
            cursor: pointer;
            text-align: left; /* Center the list items */
        }

        .hamburger {
            cursor: pointer;
            font-size: 30px;
        }

        .img-fluid {
            max-width: 200px; /* Make the image smaller */
            height: auto;
        }

        .modal-body {
            text-align: center;
        }

        .modal-body iframe {
            margin: 0 auto;
        }
    </style>
</head>

<body>
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
            <li><a href="index.php">Toán Finger Math</a></li>
            <li><a href="randomImg.php">Trò chơi Đoán Hình</a></li>
            <li>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="setup">
                    Cài đặt ngẫu nhiên
                </button>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="text-center">
            <?php
                // Generate a random number between 0 and 9
                $randomNumber = rand(0, 9);
                
                // Create the image file name
                $imageFileName = 'img/hand/' . $randomNumber . '.png';
                
                // Display the image
                echo "<img src='$imageFileName' alt='Random Image' class='img-fluid' id='randomImage'>";
            ?>
        </div>
        <div class="mt-4 text-center">
            <form id="answerForm">
                <div class="form-group">
                    <label for="userAnswer">Nhập vào câu trả lời cho câu hỏi trên:</label>
                    <input type="number" class="form-control text-center" id="userAnswer" name="userAnswer" required>
                </div>
                <button type="submit" class="btn btn-primary">Check Answer</button>
                <button type="button" class="btn btn-success" id="nextQuestion">Next Question</button>
                <button type="button" class="btn btn-secondary" id="showAnswer">Hiển thị đáp án</button>
            </form>
        </div>
    </div>

    <!-- Modal for Check Answer -->
    <div class="modal fade" id="checkAnswerModal" tabindex="-1" role="dialog" aria-labelledby="checkAnswerLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkAnswerLabel">Kết quả của bạn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="checkAnswerMessage"></p>
                    <div id="sticker"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Showing Answer -->
    <div class="modal fade" id="showAnswerModal" tabindex="-1" role="dialog" aria-labelledby="showAnswerLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showAnswerLabel">Đáp án</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="showAnswerMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <audio id="correctSound" src="music/win.mp3"></audio>
    <audio id="incorrectSound" src="music/lose.mp3"></audio>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
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

        // Handle form submission
        document.getElementById('answerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var userAnswer = parseInt(document.getElementById('userAnswer').value);
            var randomNumber = <?php echo $randomNumber; ?>;
            var checkAnswerMessage = document.getElementById('checkAnswerMessage');
            var sticker = document.getElementById('sticker');
            var correctSound = document.getElementById('correctSound');
            var incorrectSound = document.getElementById('incorrectSound');

            if (userAnswer === randomNumber) {
                checkAnswerMessage.innerHTML = "Đáp án đúng!";
                sticker.innerHTML = '<iframe src="https://giphy.com/embed/1xNDVX4DV6B5vo6unw" width="240" height="240" style="border: none;" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/molangofficialpage-game-dance-happy-1xNDVX4DV6B5vo6unw">via GIPHY</a></p>';
                correctSound.play();
            } else {
                checkAnswerMessage.innerHTML = "Đáp án sai!";
                sticker.innerHTML = '<iframe src="https://giphy.com/embed/3o6Zt481isNVuQI1l6" width="240" height="240" style="border: none;" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/3o6Zt481isNVuQI1l6">via GIPHY</a></p>';
                incorrectSound.play();
            }

            $('#checkAnswerModal').modal('show');
        });

        // Handle show answer button click
        document.getElementById('showAnswer').addEventListener('click', function() {
            var randomNumber = <?php echo $randomNumber; ?>;
            var showAnswerMessage = document.getElementById('showAnswerMessage');
            showAnswerMessage.innerHTML = "Đáp án là: " + randomNumber;
            $('#showAnswerModal').modal('show');
        });

        // Handle next question button click
        document.getElementById('nextQuestion').addEventListener('click', function() {
            location.reload(); // Reload the page to get a new random image
        });
    </script>
</body>

</html>