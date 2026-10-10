<form method="GET">
    <input type="text" name="Search">
    <button type="submit">Search</button>
</form>

<?php

if (isset($_GET["Search"])) {

$search = $_GET["Search"];


 echo "Search result for: " . $search ;
}
?>