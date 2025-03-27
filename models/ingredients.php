<?phpnamespace models;use config\connection;use Couchbase\ViewOptions;require_once '../config/connection.php';class ingredients extends connection{   public function store($ingredientName,$unit,$stock,$reorder):void   {       $query = "INSERT INTO ingredients(ingredient_Name, unit, stock_quantity, reorder_level) VALUES (?,?,?,?)";       $smt = $this->Connect()->prepare($query);       $smt->bind_param('ssdd',$ingredientName,$unit,$stock,$reorder);       if ($smt->execute()){           echo json_encode(['success' => true, 'message' => 'Successfully Added New Ingredient']);       }else{           echo json_encode(['success' => false, 'message' => 'Error'.$smt->error]);       }   }   public function showAll():array   {       $result = $this->Connect()->query("SELECT * FROM ingredients WHERE status = 'Active'");       if ($result->num_rows > 0){           $dataRow = [];           while ($row = $result->fetch_assoc()){               $dataRow[] = $row;           }           return $dataRow;       }       return [];   }   public function showBaseOnId($id):array   {       $query = "SELECT * FROM ingredients WHERE ingredientId = ?";       $stmt = $this->Connect()->prepare($query);       $stmt->bind_param('i',$id);       $stmt->execute();       $result = $stmt->get_result();       $dataRow = [];       while ($row = $result->fetch_assoc()){           $dataRow[] = $row;       }       return $dataRow;   }   public function update(string $ingredientName,string $Unit, int $stock, int $reorderLevel,int $id):void   {        $query = "UPDATE ingredients SET ingredient_Name = ? ,unit = ? ,stock_quantity = ?, reorder_level = ? WHERE ingredientId = ?";        $stmt = $this->Connect()->prepare($query);        if (!$stmt){            echo json_encode(['success' => false, 'message' => 'Failed to Prepared Statement']);            return;        }       $stmt->bind_param('ssddi',$ingredientName,$Unit,$stock,$reorderLevel,$id);        if ($stmt->execute()){            echo json_encode(['success' => true, 'message' => 'Successfully Updated']);        }else{            echo json_encode(['success' => false, 'message' => 'Error'.$stmt->error]);        }         $stmt->close();   }   public function archive(string $status, int$id):void   {       $query = "UPDATE ingredients SET status = ? WHERE ingredientId = ?";       $stmt = $this->Connect()->prepare($query);       if (!$stmt){           echo json_encode(['success' => false,'message' => 'Failed to Prepare Statement']);           return;       }       $stmt->bind_param('si',$status,$id);       if($stmt->execute()){           echo json_encode(['success' => true,'message' => 'Successfully Deleted']);       }else{           echo json_encode(['success' => false,'message' => 'Error'.$stmt->error]);       }   }    public function countIngredient( string $status):int    {        $query = "SELECT COUNT(*) AS counted FROM ingredients WHERE status = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$status);        $stmt->execute();        $result = $stmt->get_result();        $row = $result->fetch_assoc();        return (int) $row['counted'];    }}