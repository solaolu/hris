<?

//$_SESSION['user']=null;

//validate session
$doLogin=false;
if (isset($_GET['do'])) $doLogin=true;

if ((!isset($_SESSION['user'])||is_null($_SESSION['user']) || ($_SESSION['user']==''))&&(!$doLogin)) {
    $obj = (object) [ 
            'object'=>null,
            'code' => 401,
            'isSuccessful'=>false,
            'message' => "Your login session has expired, you'll need to log back on to continue using the platform."];
    
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($obj);
    die();
}


class View
{
    private $model;
    private $controller;
    

    public function __construct($controller,$model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output() {
        return json_encode($this->model->getResult());
    }
    
}
?>