<?php
session_start();
if (!$_SESSION['role']){
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include '../includes/cdn-links.php';
    ?>
    <title>Admin Dashboard</title>
</head>
<style>
    .modal{
        background: rgba(255, 255, 255, 0.11);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5.3px);
        -webkit-backdrop-filter: blur(5.3px);
    }
</style>
<body>
    <!-- start: Sidebar -->
    <div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
        <div class="d-flex align-items-center p-3">
            <a href="#" class="sidebar-logo text-uppercase fw-bold text-decoration-none text-indigo fs-4">
                <img class="img-thumbnail rounded-circle col-lg-4 col-md-5" src="../assets/images/logo-removebg-preview.png" alt="logo">
            </a>
            <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>
        </div>
        <?php
           include '../includes/admin-sidebar.php'
        ?>
    </div>
    <div class="sidebar-overlay"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <!-- start: Navbar -->
            <?php
            include '../includes/nav-bar.php'
            ?>
            <!-- end: Navbar -->

            <!-- start: Content -->
            <div class="py-4">
                <!-- start: Summary -->
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-primary">
                            <div>
                                <i class="ri-shopping-cart-line"></i>
                                <div>Sales</div>
                            </div>
                            <h4 class="fw-bold" id="totalSale"></h4>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-indigo">
                            <div>
                                <i class="ri-cup-line"></i>
                                <div>Product</div>
                            </div>
                            <h4 class="fw-bold" id="countProduct"></h4>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-success">
                            <div>
                                <i class="ri-knife-blood-line"></i>
                                <div>Recipe</div>
                            </div>
                            <h4 class="fw-bold" id="countedRecipe"></h4>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-danger">
                            <div>
                                <i class="ri-restaurant-2-line"></i>
                                <div>Ingredients</div>
                            </div>
                            <h4 class="fw-bold" id="countedIngredients"></h4>
                        </a>
                    </div>
                </div>
                <!-- end: Summary -->
                <!-- start: Graph -->
                <div class="row g-3 mt-2">
                    <div class="col-12 col-md-7 col-xl-8">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                Sales
                            </div>
                            <div class="card-body">
                                <canvas id="salesController-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-xl-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                Sales Per Day
                                <div class="card-body">
                                    <canvas id="per-day-salesController"></canvas>
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end: Graph -->
            </div>
            <!-- end: Content -->
<!--        </div>-->
    </main>
<div>
    <?php
    include '../modals/ingredient-modal.php';
    include '../modals/recipe-modal.php';
    include '../modals/cotegory-modal.php';
    include '../modals/product_modal.php';
    ?>
</div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- end: JS -->
    <script src="../JQUERY/produc.js"></script>
    <script src="../JQUERY/category.js"></script>
    <script src="../JQUERY/ingredient.js"></script>
    <script src="../JQUERY/recipe.js"></script>
    <script src="../JQUERY/cashier.js"></script>
    <script src="../JQUERY/charts.js"></script>
</body>
</html>