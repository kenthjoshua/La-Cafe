<!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Product List</title>    <?php    include '../includes/cdn-links.php';    ?></head><body><div class="py-2">    <nav  class="px-3 py-2 rounded shadow-sm">        <nav class="fw-bold mb-0 me-auto" aria-label="breadcrumb">            <ol class="breadcrumb">                <li class="breadcrumb-item">                    <a href="dashboard.php">Dashboard</a>                </li>                <li class="breadcrumb-item  active" aria-current="page">product list</li>            </ol>        </nav>        <div class="dropdown me-3 d-none d-sm-block">        </div>        <div class="dropdown">            <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown"                 aria-expanded="false">                <span class="me-2 d-none d-sm-block">Admin</span>                <img class="navbar-profile-image"                     src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8cGVyc29ufGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60"                     alt="Image">            </div>            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">                <li><a class="dropdown-item" href="../config/logout.php">Logout</a></li>            </ul>        </div>    </nav>    <div class="container-fluid">        <table id="myTable" class="table table-hover table-hover table-striped">            <thead>            <tr>                <th>#</th>                <th>Image</th>                <th>Product Name</th>                <th>Category</th>                <th>Price</th>               <th>Action</th>            </tr>            </thead>            <tbody>            <?php            require_once '../controllers/productController.php';            $products = new \controller\productController();            $products->showProductList('Active');            ?>            </tbody>        </table>    </div></div><div id="modal_con"></div></body></html><script src="../JQUERY/produc.js"></script><script>    new DataTable('#myTable', {        paging: true,        responsive: true    } );</script>