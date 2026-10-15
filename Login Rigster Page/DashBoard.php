
<?php
require_once "db.php";


$Query ="SELECT * FROM `users` ";



$stm = $conn->prepare($Query);

 $stm->execute();

 $result = $stm->get_result();

 if($result->num_rows == 0) {

  echo "Server Erorr";

 }



 function AddNewUSer($conn,$Name, $email) :bool {


 $FakePAss = "123456";
     
    $sql = "INSERT INTO users (name, email, password, created_at)
        VALUES (?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $Name, $email, $FakePAss);

    if($stmt->execute()) {

    return true;

    }

     return false;


 }

 function DeleteUSerById($conn,$id) :bool {



     
     $Query = 'DELETE FROM `users` WHERE id = ?';

    $stmt = $conn->prepare($Query);
    $stmt->bind_param("i", $id,);

    if($stmt->execute()) {

    return true;

    }

     return false;


 }



 if ($_SERVER["REQUEST_METHOD"] == "POST") {  

      $name = trim($_POST["name"]);
      $email = trim($_POST["email"]);

      if($name != ""&& $email !="") {  


        if (!AddNewUSer($conn,$name,$email)){

                      

        }
       }


         $Query = 'DELETE FROM `users` WHERE id = ?';

    if ( DeleteUSerById($conn,$_POST['delete_id'])){


            echo "USEr DEleted";
    }
    else{



    }

      


 }


 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {

  



 }




 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management</title>
<link rel="stylesheet" href="style.css">

</head>

<body>
  <main class="container">
    <header>
      <h1>User Management</h1>
      <p class="subtitle">
        View, add, edit, and remove registered users.
      </p>
    </header>

    <section class="card" aria-labelledby="form-heading">
      <h2 id="form-heading">Add a new user</h2>

      <!-- CREATE: Your backend handles POST /users. -->
      <form class="user-form" action="" method="post">
        <!-- Add your backend's CSRF token here. -->

        <div>
          <label for="name">Full name</label>
          <input
            type="text"
            id="name"
            name="name"
            placeholder="Enter full name"
            autocomplete="name"
            maxlength="100"
            required
          >
        </div>

        <div>
          <label for="email">Email address</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="name@example.com"
            autocomplete="email"
            required
          >
        </div>

        <button class="button primary" type="submit">
          Add user
        </button>
      </form>
    </section>

    <section class="card" aria-labelledby="users-heading">
      <h2 id="users-heading">Registered users</h2>

      <!-- READ: Render all registered users here from your backend. -->
      <div class="table-wrapper">
        <table>
          <caption>Sample users — replace with database records.</caption>
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Full name</th>
              <th scope="col">Email address</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>

          <tbody>

            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?></td>
              
                <td>
             
                  <div class="actions">
                    <a
                      class="button edit"
                      href="/users/1/edit"
                      aria-label="Edit Alex Morgan"> Edit</a>
                      
                      <button
                        class="button delete"
                        type="submit"
                        aria-label="Delete Alex Morgan"
                        name="delete_id"
                        value="<?= (int) $row['id'] ?>"
                      >Delete</button>
            </form>
                </div>



                
              

               
              </td>
            </tr>
            <?php endwhile; ?>
            
          </tbody>
        </table>
      </div>

      <p class="privacy-note">
        Passwords are never shown in this interface.
      </p>
    </section>
  </main>
</body>
</html>