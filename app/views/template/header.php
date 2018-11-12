<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Architecture MVC</title>
        <link rel="stylesheet" href= "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href= "/assets/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-success">
            <div class="container">
                <ul class="navbar-nav pull-xs-right text-xs-center">
                    <?php if ( !isset($_SESSION['auth'] ) || empty( $_SESSION['auth'] ) ) :?>
                        <li class="nav-item">
                            <a class="nav-link" href="register">s'inscrire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login">se connecter</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="account">Mon compte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout">Déconnexion</a>
                        </li> 
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <?php
            if (isset ( $_SESSION['success']) )
            {
                var_dump($_SESSION['success'] );
                unset( $_SESSION['success'] );
            }
            if (isset ( $_SESSION['errors']) )
            {
                var_dump($_SESSION['errors'] );
                unset( $_SESSION['errors'] );
            }
            
        ?>