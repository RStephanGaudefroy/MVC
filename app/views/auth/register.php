<?php include ROOT . 'app/views/template/header.php'; ?>

<body>
    <div class="container">
        <h1 class="text-xs-center">Register</h1>
        <div class="row">
            <div class="col-xl-4 col-xl-offset col-md-6 col-md-offset-3">
                <form action="register/postRegister" method="post" class="p-y-3 p-x-2" novalidate>
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>" />
                    <input type="text" name="username" class="form-control" placeholder="Pseudo">
                    <input type="email" name="email" class="form-control" placeholder="Adresse e-mail">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                    <input type="password" name="passwordConf" class="form-control" placeholder="Confirmez le mot de passe">
                    <input type="submit" value="Register" class="btn btn-success m-b-1">
                </form>
            </div>
        </div>
        <?php 
            var_dump($data);
            
        ?>
        </div>
</body>
</html>