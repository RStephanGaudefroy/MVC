<?php include ROOT . 'app/views/template/header.php'; ?>

<body>
    <div class="container">
        <h1 class="text-xs-center">Oubli mot de passe</h1>
        <div class="row">
            <div class="col-xl-4 col-xl-offset col-md-6 col-md-offset-3">
                <form action="forgotPassword/postForget" method="post" class="p-y-3 p-x-2" novalidate>
                    <input type="email" name="email" class="form-control" placeholder="Adresse e-mail">
                    <input type="submit" name="send" class="btn btn-success m-b-1">
                </form>
            </div>
        </div>
        <?php 
            if (isset($data) && !empty($data))
                var_dump($data['errors']);
        ?>
        </div>
</body>
</html>