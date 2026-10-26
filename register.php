<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kartify - Register</title>
    <link rel="stylesheet" href="http://localhost:81/kartify/style.css">
    <script>
        function toggleContact() {
            var useEmail = document.getElementById("useEmail").checked;
            var usePhone = document.getElementById("usePhone").checked;
            var emailRow = document.getElementById("emailRow");
            var phoneRow = document.getElementById("phoneRow");
            var emailField = document.getElementById("em");
            var phoneField = document.getElementById("nu");
            if (useEmail) {
                emailRow.style.display = ""; phoneRow.style.display = "none";
                emailField.disabled = false; phoneField.disabled = true; phoneField.value = "";
            } else if (usePhone) {
                emailRow.style.display = "none"; phoneRow.style.display = "";
                emailField.disabled = true; phoneField.disabled = false; emailField.value = "";
            } else {
                emailRow.style.display = ""; phoneRow.style.display = "";
                emailField.disabled = false; phoneField.disabled = false;
            }
        }

        function registervalidation() {
            var fields = ["n", "d", "em", "nu", "u", "p"];
            for (var i = 0; i < fields.length; i++) document.getElementById(fields[i]).style.borderColor = "";
            var name = document.getElementById("n").value.trim();
            var genderFemale = document.getElementById("female").checked;
            var genderMale = document.getElementById("male").checked;
            var dob = document.getElementById("d").value;
            var useEmail = document.getElementById("useEmail").checked;
            var usePhone = document.getElementById("usePhone").checked;
            var email = document.getElementById("em").value.trim();
            var phone = document.getElementById("nu").value.trim();
            var username = document.getElementById("u").value.trim();
            var password = document.getElementById("p").value;

            if (name === "") { alert("Please enter your Name!!"); document.getElementById("n").focus(); document.getElementById("n").style.borderColor = "red"; return; }
            if (name.length < 3) { alert("Name min 3 chars!!"); document.getElementById("n").focus(); document.getElementById("n").style.borderColor = "red"; return; }
            if (!/^[A-Za-z\s]+$/.test(name)) { alert("Name letters only!!"); document.getElementById("n").focus(); document.getElementById("n").style.borderColor = "red"; return; }
            if (!genderFemale && !genderMale) { alert("Select Gender!!"); return; }
            if (dob === "") { alert("Select DOB!!"); document.getElementById("d").focus(); document.getElementById("d").style.borderColor = "red"; return; }
            var dobDate = new Date(dob); var today = new Date();
            var age = today.getFullYear() - dobDate.getFullYear();
            var m = today.getMonth() - dobDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) age--;
            if (dobDate > today) { alert("DOB cannot be future!!"); document.getElementById("d").focus(); document.getElementById("d").style.borderColor = "red"; return; }
            if (age < 18) { alert("Must be 18+!!"); document.getElementById("d").focus(); document.getElementById("d").style.borderColor = "red"; return; }
            if (!useEmail && !usePhone) { alert("Select contact method!!"); return; }
            if (useEmail) {
                if (email === "") { alert("Enter Email!!"); document.getElementById("em").focus(); document.getElementById("em").style.borderColor = "red"; return; }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert("Valid Email required!!"); document.getElementById("em").focus(); document.getElementById("em").style.borderColor = "red"; return; }
            }
            if (usePhone) {
                if (phone === "") { alert("Enter Phone!!"); document.getElementById("nu").focus(); document.getElementById("nu").style.borderColor = "red"; return; }
                if (!/^[0-9]{10}$/.test(phone)) { alert("Phone 10 digits!!"); document.getElementById("nu").focus(); document.getElementById("nu").style.borderColor = "red"; return; }
            }
            if (username === "") { alert("Enter Username!!"); document.getElementById("u").focus(); document.getElementById("u").style.borderColor = "red"; return; }
            if (username.length < 4) { alert("Username min 4 chars!!"); document.getElementById("u").focus(); document.getElementById("u").style.borderColor = "red"; return; }
            if (!/^[A-Za-z0-9_]+$/.test(username)) { alert("Username alphanumeric/underscore only!!"); document.getElementById("u").focus(); document.getElementById("u").style.borderColor = "red"; return; }
            if (password === "") { alert("Enter Password!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            if (password.length < 8) { alert("Password min 8 chars!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            if (!/[A-Z]/.test(password)) { alert("Need uppercase!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            if (!/[a-z]/.test(password)) { alert("Need lowercase!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            if (!/[0-9]/.test(password)) { alert("Need number!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) { alert("Need special char!!"); document.getElementById("p").focus(); document.getElementById("p").style.borderColor = "red"; return; }
            document.getElementById("regfrm").submit();
        }
    </script>
</head>
<body>
    <header id="header">
        <table>
            <tr>
                <td><img src="http://localhost:81/kartify/Logo.png" alt="Kartify Logo"></td>
                <td>
                    <nav>
                        <a href="http://localhost:81/kartify/index.html">Home</a>
                        <a href="http://localhost:81/kartify/login.php">Login</a>
                    </nav>
                </td>
            </tr>
        </table>
    </header>

    <main id="content">
        <h1>Create Your Kartify Account</h1>
        <p>Join millions of happy shoppers today!</p>

        <form name="regfrm" id="regfrm" action="http://localhost:81/kartify/registerhandler.php" method="post">
            <table>
                <tr><th colspan="2">Register</th></tr>
                <tr><td><label for="n">Name</label></td><td><input type="text" name="n" id="n"></td></tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" id="female" name="g" value="Female"><label for="female">Female</label><br>
                        <input type="radio" id="male" name="g" value="Male"><label for="male">Male</label>
                    </td>
                </tr>
                <tr><td><label for="d">DOB</label></td><td><input type="date" name="d" id="d"></td></tr>
                <tr>
                    <td>Preferred Contact</td>
                    <td>
                        <input type="radio" id="useEmail" name="contactPref" value="Email" onchange="toggleContact()"><label for="useEmail">Email</label><br>
                        <input type="radio" id="usePhone" name="contactPref" value="Phone" onchange="toggleContact()"><label for="usePhone">Phone</label>
                    </td>
                </tr>
                <tr id="emailRow"><td><label for="em">Email</label></td><td><input type="email" name="em" id="em"></td></tr>
                <tr id="phoneRow"><td><label for="nu">Phone</label></td><td><input type="tel" name="nu" id="nu"></td></tr>
                <tr><td><label for="u">Username</label></td><td><input type="text" name="u" id="u"></td></tr>
                <tr><td><label for="p">Password</label></td><td><input type="password" name="p" id="p"></td></tr>
                <tr>
                    <td><button type="reset" onclick="setTimeout(toggleContact, 0)">Reset</button></td>
                    <td><button type="button" onclick="registervalidation()">Register</button></td>
                </tr>
            </table>
            <div style="color: red; text-align: center; margin-top: 10px;">
                <?php if (isset($_GET['msg'])) { echo htmlspecialchars($_GET['msg']); } ?>
            </div>
        </form>
        <p>Already have an account? <a href="http://localhost:81/kartify/login.php">Login here</a></p>
    </main>
    <footer id="footer"><p>@Kartify 2025 — Shop Smart, Live Better</p></footer>
</body>
</html>