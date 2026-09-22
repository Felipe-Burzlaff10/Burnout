<a href="logout.php">
    <button>logout</button>
</a>

<?php
session_start();

if (isset($_SESSION['id_usuario']))
{
    if ($_SESSION['root'])
            echo "<a href='listar_users.php'>
                      <button>listar</button>
                  </a>";
}
else
    header("Location: login.php");
?>