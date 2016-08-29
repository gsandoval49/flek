<?php require_once("php/partials/head-utils.php");?>

<body class="sfooter">
<div class="sfooter-content">

    <!--begin header-->
    <?php require_once ("php/partials/header.php")?>

    <!--begin main content -->
    <main>
        <div class="container-fluid">

            <!-- added view from #3 in directives. this is angular view directive, where main content view will be updated -->
            <div ng-view></div>

        </div>
    </main>
</div>

<!--begin footer -->
<!-- require once -->
<?php require_once ("php/partials/header.php")?>
</body>
</html>