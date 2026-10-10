<?php
session_start();


class user
{
    public $id;
    public $username;
    public $email;
    public $moblile;
    public $Governorate;
    public $Track;
    public  $skills = [];
    public $messagetype;
    public function __construct($id, $username, $email, $mob, $Governorate, $Track, $skills, $messagetype)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->moblile = $mob;
        $this->Governorate = $Governorate;
        $this->Track = $Track;

        $this->skills = $skills;
        $this->messagetype = $messagetype;
    }
}

$DeffultUser = new user(1, "", "", "", "", "", "", "");
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $NAME = trim($_POST["name"] ?? "");
    $Email = trim($_POST["email"] ?? "");
    $Mobile = trim($_POST["mobile"] ?? "");
    $governorate = trim($_POST["governorate"] ?? "");
    $Track = trim($_POST["track"] ?? "");
    $Skills = $_POST["skills"] ?? [];
    $comment = trim($_POST["message"] ?? "");


    $errors = [];


    if ($NAME === "") {

        $errors["name"] = "Name is required";
    } else if (mb_strlen($NAME) < 2) {

        $errors["name"] = "Name must be more then 2 chars";
    }



    if ($Email === "") {

        $errors["email"] = "Email is required";
    } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {

        $errors["email"] = "Invalid Email";
    }

    if ($Mobile === "") {

        $errors["Mobile"] = "required";
    } else if (!str_contains($Mobile, "07")) {

        $errors["Mobile"] = "must start with  07";
    }

    if ($governorate === "") {
        $errors["governorate"] = "Governorate must be selected";
    }

    if ($Track === "") {
        $errors["track"] = "Please select a track";
    }

    if (empty($Skills)) {
        $errors["skills"] = "Please select at least one skill";
    }

    if (!isset($_POST["agree"])) {
        $errors["agree"] = "You must accept the terms";
    }



    if (empty($errors)) {

        $_SESSION["name"] = $NAME;
        $_SESSION["email"] = $Email;
        $_SESSION["mobile"] = $Mobile;
        $_SESSION["governorate"] = $governorate;
        $_SESSION["track"] = $Track;
        $_SESSION["skills"] = $Skills;
        $_SESSION["comment"] = $comment;

        $DeffultUser =  new user(
            1,
            $NAME,
            $Email,
            $Mobile,
            $governorate,
            $Track,
            $Skills,
            $comment
        );

        setcookie("name", $DeffultUser->username, time() + 3600, "/");
        setcookie("email", $DeffultUser->email, time() + 3600, "/");

        header("Location: userData.php");
        exit;
    }
}





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="Rigster.php" method="post">

        <label for="name">Full Name</label>
        <input
            type="text"
            id="name"
            name="name">

        <?php if (isset($errors["name"])): ?>

            <p class="error">

                <?= htmlspecialchars($errors["name"]) ?>

            </p>
        <?php endif; ?>

        <label for="email">Email</label>
        <input type="email"
            id="email"
            name="email">

        <?php if (isset($errors['email'])): ?>

            <p class="error">

                <?= htmlspecialchars($errors['email']) ?>

            </p>
        <?php endif; ?>





        <label for="mobile">Mobile</label>
        <input type="tel" id="mobile" name="mobile" placeholder="0791234567">
        <?php if (isset($errors['Mobile'])): ?>
            <p class="error">
                <?= htmlspecialchars($errors['Mobile']) ?>

            </p>
        <?php endif; ?>



        <label for="governorate">Governorate</label>
        <select id="governorate" name="governorate">
            <option value="">Choose a governorate</option>
            <option value="Amman">Amman</option>
            <option value="Irbid">Irbid</option>
            <option value="Aqaba">Aqaba</option>
            <option value="Zarqa">Zarqa</option>
        </select>
        <?php if (isset($errors['governorate'])): ?>
            <p class="error">
                <?= htmlspecialchars($errors['governorate']) ?>

            </p>
        <?php endif; ?>

        <label>Track</label>
        <?php if (isset($errors['track'])): ?>
            <p class="error">
                <?= htmlspecialchars($errors['track']) ?>

            </p>
        <?php endif; ?>


        <label class="inline">
            <input type="radio" name="track" value="Full Stack">
            Full Stack
        </label>

        <label class="inline">
            <input type="radio" name="track" value="Frontend">
            Frontend
        </label>

        <label class="inline">
            <input type="radio" name="track" value="Backend">
            Backend
        </label>

        <label>Skills you already have</label>
        <?php if (isset($errors['skills'])): ?>
            <p class="error">
                <?= htmlspecialchars($errors['skills']) ?>

            </p>
        <?php endif; ?>


        <label class="inline">
            <input type="checkbox" name="skills[]" value="HTML">
            HTML
        </label>

        <label class="inline">
            <input type="checkbox" name="skills[]" value="CSS">
            CSS
        </label>

        <label class="inline">
            <input type="checkbox" name="skills[]" value="JavaScript">
            JavaScript
        </label>

        <label for="message">Why do you want to join? (optional)</label>
        <textarea id="message" name="message" rows="4"></textarea>

        <label class="inline terms">
            <input type="checkbox" name="agree">
            I agree to the academy terms
        </label>
        <?php if (isset($errors['track'])): ?>
            <p class="error">
                <?= htmlspecialchars($errors['agree']) ?>

            </p>
        <?php endif; ?>



        <button  type="submit">Register</button>

    </form>
</body>

</html>