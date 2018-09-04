<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
}
$user = $_SESSION["login"]["user"];
require_once "init.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/jpg" href="recurso/imagenes/gota.ico" />
        <title>CULTISOFT</title>
        <?php include './MVC/Vista/Recursos/style.php'; ?>
        <!-- REQUIRED JS SCRIPTS -->
        <?php include './MVC/Vista/Recursos/script.php'; ?>

    </head>
    <body class="hold-transition fixed skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="index.php" class="logo" style="background-color: #222d32;">
                    <span class="logo-mini"><b>S</b>RP</span>
                    <div style="display: flex; flex-flow: row; justify-content: center; ">
                        <label>CULTISOFT</label>
                    </div>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <i class="fa fa-align-justify"></i>
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <span style="padding: 15px 15px;color: white;float: left;" fecha></span>
                    <input type="text" class="hidden" nombres value="<?php echo $user["nombres"] ?>">
                    <input type="text" class="hidden" iduser value="<?php echo $user["id"] ?>">
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-user-circle" style="font-size: 18px;"></i>
                                    <span class="hidden-xs"><?php echo $user["nombres"] ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <i class="fa fa-user fa-2x"></i>
                                        <p>
                                            <?php echo $user["username"] . " - " . $user["rol"]; ?>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="#" id="cerrarSesion" class="btn btn-default btn-flat">Cerrar Sesión</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar"> 
                <section class="sidebar">
                    <?php include './MVC/Vista/Recursos/panelNavegacion.php'; ?>
                </section>
            </aside>
            <div class="content-wrapper" id="containPages">
                



            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    CULTISOFT
                </div>
                <strong>Copyright</strong> CultiSoft 2018.
            </footer>
        </div>
        <script type="text/javascript">
            $("#containPages").load('MVC/Vista/Reportes/Dashboard.php');
        </script>
    </body>
</html>
