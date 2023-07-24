<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    * {
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        display: flex;
        height: 95vh;
    }

    form {
        margin: auto;
        min-width: 570px;

        padding: 36px;
        border: 1px solid #ccc;
        background-color: #fff;
        box-shadow: 1px 1px 1px rgba(255, 255, 255, 1);

    }

    .form_ele {
        padding: 12px 0;
        display: flex;
        align-items: center;
    }

    .form_ele input {
        font-size: 14px;
        padding: 12px;
        border-radius: 6px;
        flex: 1;
    }

    .form_ele textarea {
        flex: 1;
    }

    input[type="submit"] {
        padding: 12px;
        font-size: 18px;
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 6px;
        transition: all 0.2 linear;
        cursor: pointer;

    }

    input[type="submit"]:hover {
        background-color: #ccc;
    }

    label {
        font-size: 16px;
        font-weight: 400;
        width: 20%;
    }

    #result {
        padding: 24px 0px;
        font-size: 12px;

    }

    #result_in {
        position: fixed;
        right: 0px;
        top: 10%;
    }

    .wrapper {
        right: -100%;
        width: 400px;
        height: 100px;
        background-color: #fff;
        font-size: 16px;
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
        border-left-width: 10px;
        margin: 10px;
        animation: showIn linear 0.3s forwards;
        position: relative;
    }

    .wrapper h2 {
        border-right: 1px solid #ccc;
        display: block;
    }

    .wrapper p {
        padding: 0px 12px;
    }

    .display-none {
        display: none;
    }

    @keyframes showIn {
        from {
            opacity: 0.5;
        }

        to {
            opacity: 1;
            right: 0;
        }
    }

    .wrapper::after {
        content: "";
        position: absolute;
        bottom: -6px;
        width: 102%;
        left: -10px;
        height: 8px;
        border-radius: 6px;
        animation: fadeOut linear 2s;
    }

    .wrapper.success::after {
        background-color: rgb(0 96 72 / 60%);

    }

    .wrapper.error::after {
        background-color: red;

    }

    .wrapper.success {
        border-left-color: greenyellow;
    }

    .wrapper.error {
        border-left-color: red;

    }

    @keyframes fadeOut {
        20% {
            width: 100%;
        }

        100% {
            width: 0%;

        }
    }

    .wrapper.success h2 {
        color: greenyellow;
        padding: 12px;
    }

    .wrapper.error h2 {
        color: red;
        padding: 12px;
    }
    </style>

</head>

<body>

    <form id="commentForm" method="post">
        <h2>Viết bình luận</h2>
        <div class="form_ele">
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name"><br>

        </div>

        <div class="form_ele">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>
        </div>

        <div class="form_ele">
            <label for="comment">Bình luận:</label>
            <textarea id="comment" name="comment" rows="5"></textarea><br>
        </div>

        <input type="submit" value="Gửi bình luận">
        <div id="result"></div>
        <div id="result_in">
            <div class="wrapper display-none success">
                <h2>Success</h2>
                <p>Bình luận của bạn đã được phê duyệt</p>
            </div>
            <div class="wrapper display-none error">
                <h2>Error</h2>
                <p></p>
            </div>
            <!-- <div class="outding"></div> -->
        </div>
    </form>
</body>


<script>
var form = document.getElementById('commentForm');
var resultDiv = document.getElementById('result');
const resDev = document.getElementById('result_in');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            console.log(xhr.responseText);
            if (xhr.status === 200) {
                resultDiv.innerHTML = xhr.responseText;
                const temps = resDev.getElementsByClassName('wrapper')
                if (!xhr.responseText.includes('không hợp lệ')) {
                    form.name.value = "";
                    form.email.value = "";
                    form.comment.value = "";
                    const temp = temps[0];
                    temp.classList.remove('display-none');
                    setTimeout(() => {
                        temp.classList.add('display-none');
                    }, 2000)
                } else {
                    const temp = temps[1];
                    temp.classList.remove('display-none');
                    temp.getElementsByTagName('p')[0].innerHTML = xhr.responseText;
                    setTimeout(() => {
                        temp.classList.add('display-none');
                    }, 2000)
                }

            } else {
                resultDiv.innerHTML = 'Đã có lỗi xảy ra.';
            }

        }
    };
    xhr.open('POST', 'process.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('name=' + encodeURIComponent(form.name.value) +
        '&email=' + encodeURIComponent(form.email.value) +
        '&comment=' + encodeURIComponent(form.comment.value));
});
</script>

</html>