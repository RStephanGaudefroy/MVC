<?php include ROOT . 'App/Views/template/header.php'; ?>

<body>
    <div class="container">
        <h1 class="text-xs-center">Connexion</h1>
        <div class="row">
            <div class="col-xl-4 col-xl-offset col-md-6 col-md-offset-3">
                <form action="login/postLogin" method="post" class="p-y-3 p-x-2" novalidate>
                    <input type="email" name="email" class="form-control" placeholder="Adresse e-mail">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                    <input type="submit" value="Connexion" class="btn btn-success m-b-1">
                </form>
            </div>
        </div>
        <?php 
            if (isset($data) && !empty($data))
            {
                var_dump($data['errors']);
                //echo '<div class="alert alert-danger"></div>';
            }
        ?>
    </div>
</body>
</html>