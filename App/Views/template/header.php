<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Architecture MVC</title>
        <link rel="stylesheet" href= "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-success">
            <div class="container">
                <ul class="navbar-nav pull-xs-right text-xs-center">
                    <?php if ( !isset($_SESSION['auth'] ) ) :?>
                        <li class="nav-item">
                            <a class="nav-link" href="account/index">Mon compte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout/logout">Déconnexion</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="register/index">S'inscrire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login/index">se connecter</a>
                        </li> 
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

