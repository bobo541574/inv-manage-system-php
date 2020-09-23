<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?php echo DOMAIN . "/dashboard.php" ?>"><i class="fas fa-warehouse"></i> Inventory
        System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (isset($_SESSION['id'])) : ?>
            <li class="nav-item active">
                <!-- <a class="nav-link" href="#"><i class="fa fa-sign-out"></i> Logout</a> -->
                <form action="<?php echo DOMAIN . "/includes/Auth.php" ?>" method="post">
                    <input type="hidden" name="logout" value="LOGOUT">
                    <button class="nav-link active btn"><i class="fa fa-sign-out-alt"></i>
                        Logout</button>
                </form>
            </li>
            <?php endif ?>
        </ul>
    </div>
</nav>