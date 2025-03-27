<?phpnamespace controller;use http\Params;use models\category;use models\product;require_once '../models/product.php';class productController{    public function store():void    {        $fields = [            'productName' => 'product name is required',            'Price' => 'price is required',            'category' => 'please select category',        ];        $data = [];        $error = [];        foreach ($fields as $field => $message){            if (!isset($_POST[$field]) || trim($_POST[$field]) === ''){                $error[$field] = $message;            }else{                $data[$field] = htmlspecialchars($_POST[$field]);            }        }        if (!empty($error)){            $data['success'] = false;            $data['errors'] = $error;            echo json_encode($data);            return;        }        // handle the image upload        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {            echo json_encode(['success' => false, 'message' => 'please upload a valid product image']);            return;        }else{            $imageDIR = '../assets/productImages';            $fileInfo = pathinfo($_FILES['image']['name']);            $fileExtension = strtolower($fileInfo['extension']);            $fileName = uniqid() . '.' . $fileExtension;            $uploadFilePath = $imageDIR . $fileName;            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath)) {                echo json_encode(['success' => false, 'message' => 'Failed to upload the image. Please try again.']);            } else {                $data['image'] = $fileName; // Save the file name to the database            }        }        $products = new product();        $products->store($data['productName'],$data['image'],$data['Price'],$data['category']);    }    public function show($status):void    {        $productList = new product();        $data = $productList->showAll($status);        $select = '';        if ($data) {            foreach ($data as $row) {                $select .= '<option value="'.htmlspecialchars($row['productId'], ENT_QUOTES, 'UTF-8').'">'                    .htmlspecialchars($row['productName'], ENT_QUOTES, 'UTF-8').'</option>';            }        }        echo $select;    }    public function showProductList(string $status): void // display the list of product in the product list page    {        $productList = new product();        $data = $productList->showAll($status);        $tableTr = '';        if ($data) {            foreach ($data as $row) {                $tableTr .= '            <tr>                <th>' . $row['productId'] . '</th>                <td>                    <img style="width: 50px; height: 50px; object-fit: cover" class="img-thumbnail rounded-circle" src="../assets/productImages'.$row['product_Image'] . '" alt="productImage">                </td>                <td>' . $row['productName'] . '</td>                <td>' . $row['category'] . '</td>                <th>' . $row['price'] . '</th>                <td>                    <button style="background-color: #6610F2" value="' . $row['productId'] . '" id="btnEdit" class="btn badge text-light">Edit</button>                    <button style="background-color: #6610F2" value="' . $row['productId'] . '" id="btnAchive" class="btn badge text-light">Archive</button>                </td>            </tr>        ';            }            echo $tableTr;        }    }    public function showBaseOnId():void    {        $productId = $_POST['Id'];        $product = new product();        $data = $product->showBaseOnId($productId);        $modal = '';        foreach ($data as $row){            $modal .= '<div class="modal fade" id="UpdateProductModal_'.$productId.'" tabindex="-1" aria-labelledby="exampleModalLabel"  data-bs-backdrop="static" aria-hidden="true">    <form id="UpdateproductForm" class="modal-dialog modal-dialog-centered modal-lg">        <div class="modal-content">            <div style="background-color: #6610F2" class="modal-header">                <h1 class="modal-title fs-6 text-light" id="exampleModalLabel">Update Product Details</h1>                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>            </div>            <div class="modal-body">                <div class="form-floating mb-3">                    <input type="text" value="'.$row['productName'].'" name="productName" class="form-control" id="productName">                    <label for="productName">Product Name</label>                    <div id="productName_msg" class="invalid-feedback"></div>                </div>                        <div class="form-floating mb-3">                    <input min="0" value="'.$row['price'].'" type="number" name="price" class="form-control" id="Price">                    <label for="Price">Price</label>                    <div id="Price_msg" class="invalid-feedback"></div>                </div>            <div class="container-fluid">                <label style="border: dotted #6610F2" for="image" class="container-fluid p-3 rounded-2">                    <input id="image" class="form-control" type="file" name="image"  accept="image/jpeg,image/png">                    <div id="image_msg" class="invalid-feedback"></div>                </label>            </div>              <input type="hidden" name="currentImage" value="'.$row['product_Image'].'">              <input type="hidden" name="productId" value="'.$productId.'">            </div>            <div class="modal-footer">                <button  type="button" class="btn bg-danger text-light bg-opacity-75" data-bs-dismiss="modal">Close</button>                <button style="background-color: #6610F2" type="submit" class="btn text-light">                    Save Changes                </button>            </div>        </div>    </form></div>      ';        }        echo $modal;    }    public function saveProductUpdated(): void    {        $productName = htmlspecialchars($_POST['productName']);        $price = htmlspecialchars($_POST['price']);        $productId = $_POST['productId'];        $currentImage = $_POST['currentImage'];        $image = $_FILES['image'];        $imageDIR = '../assets/productImages';        $data = [            'productName' => $productName,            'price' => $price,             'productId' => $productId        ];        if (!empty($image['name'])){// check if the file input is !empty then upload the new image             $fileInfo = pathinfo($image['name']);             $fileExtension = strtolower($fileInfo['extension']);             $fileName = uniqid(). '.' .$fileExtension;             $uploadFilePath = $imageDIR .$fileName;             // move the uploaded file            if (!move_uploaded_file($image['tmp_name'],$uploadFilePath)){                echo json_encode(['success' => false, 'Failed to upload the image . please try again']);                return;            }else{                $data['image'] = $fileName;            }        }else{            $data['image'] = $currentImage;        }        // insert the data        $updatedProduct = new product();        $updatedProduct->updateBaseOnId($data['productName'],$data['image'],$data['price'],$data['productId']);    }    public function archive(): void    {        $productId = $_POST['Id'];        $status = 'isDeleted';        if (!isset($productId)){            echo json_encode(['success' => false, 'message' => 'No Product Id probated']);            return;        }        $product = new product();        $product->ArchiveProduct($status,$productId);    }    public function productCounter(string $status): void    {        // Create product object and get count        $counter = new product();        $count = $counter->countProductList($status);        // Output the count        echo json_encode($count);    }}if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){    $product = new productController();    switch ($_POST['action']){        case 'store':            $product->store();            break;        case 'showBaseOnId':            $product->showBaseOnId();            break;        case 'SaveUpdatedProduct':            $product->saveProductUpdated();            break;        case 'archive':            $product->archive();            break;        case 'count':            $product->productCounter('Active');            break;    }}