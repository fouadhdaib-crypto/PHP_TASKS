
<?php
session_start();

if (!isset($_SESSION["name"])) {
    header("Location: Rigster.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>

    <h2>Registered User Information</h2>

    <p>
        <strong>Name:</strong>
        <?= htmlspecialchars($_SESSION["name"]) ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?= htmlspecialchars($_SESSION["email"]) ?>
    </p>

    <p>
        <strong>Mobile:</strong>
        <?= htmlspecialchars($_SESSION["mobile"]) ?>
    </p>

    <p>
        <strong>Governorate:</strong>
        <?= htmlspecialchars($_SESSION["governorate"]) ?>
    </p>

    <p>
        <strong>Track:</strong>
        <?= htmlspecialchars($_SESSION["track"]) ?>
    </p>

    <p>
        <strong>Skills:</strong>
        <?= htmlspecialchars(implode(", ", $_SESSION["skills"])) ?>
    </p>

    <p>
        <strong>Comment:</strong>
        <?= htmlspecialchars($_SESSION["comment"]) ?>
    </p>

    <a href="Rigster.php">Logout</a>

</body>
</html>
