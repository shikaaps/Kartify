<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartify - Login</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function loginvalidation() {
            document.getElementById("n").style.borderColor = "";
            document.getElementById("p").style.borderColor = "";
            var username = document.getElementById("n").value.trim();
            var password = document.getElementById("p").value;
            if (username === "") { alert("Please enter your Username!!"); document.getElementById("n").focus(); document.getElementById("n").style.borderColor = "red"; return; }
            if (username.length < 4) { alert("Username must be at least 4 characters long!!"); document.getElementById("n").focus(); document.getElementById("n").style.borderColor = "red"; return; }
            if (password === "") { alert("Please enter your Password!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            document.getElementById("loginfrm").submit();
        }
    </script>
</head>
<body>
    <header id="header">
        <table>
            <tr>
                <td><img src="Logo.png" alt="Kartify Logo"></td>
                <td>
                    <nav>
                        <a href="index.html">Home</a>
                        <a href="register.php">Register</a>
                    </nav>
                </td>
            </tr>
        </table>
    </header>

    <main id="content">
        <h1>Login to Kartify</h1>
        <p>Welcome back! Sign in to continue shopping.</p>

        <form name="loginfrm" id="loginfrm" action="loginhandler.php" method="get">
            <table>
                <tr><th colspan="2">Login</th></tr>
                <tr>
                    <td><label for="n">Username</label></td>
                    <td><input type="text" name="n" id="n"></td>
                </tr>
                <tr>
                    <td><label for="p">Password</label></td>
                    <td><input type="password" name="p" id="p"></td>
                </tr>
                <tr>
                    <td><button type="reset">Reset</button></td>
                    <td><button type="button" onclick="loginvalidation()">Login</button></td>
                </tr>
            </table>
            <div style="color: red; text-align: center; margin-top: 10px;">
                <?php if (isset($_GET['msg'])) { echo htmlspecialchars($_GET['msg']); } ?>
            </div>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </main>

    <footer id="footer"><p>@Kartify 2025 — Shop Smart, Live Better</p></footer>
</body>
</html>