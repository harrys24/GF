<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
class DebugController extends Controller
{
    public function index(){
        $header['title']='Gebugage';
        $header['current_menu']='AUTRES';
        $header['css']=['/src/scrud'];
        $header['js']=['/src/cplugs','/src/debug'];
       
        $this->renderH($header);
        $this->render('index');
        $this->renderF();
    }

    public function InscrE()
    {
        Utils::HeaderJS();
        $con=Database::getConnection();
        try {
            $sql='DELETE FROM inscription WHERE Etudiant_nie=?;DELETE FROM etudiant WHERE nie=?;';
            $stmt=$con->prepare($sql);
            $isok=$stmt->execute([$_POST['nie'],$_POST['nie']]);
            if ($isok) {
                echo \json_encode([
                    'color'=>'info',
                    'message'=>'Bien supprimé',
                    'response'=>'ok'
                ]);
            } else {
                echo \json_encode([
                    'color'=>'danger',
                    'message'=>'Erreur de suppression',
                    'response'=>'ko'
                ]);
                # code...
            }
            
        } catch (\PDOException $ex) {
            echo \json_encode([
                'color'=>'danger',
                'message'=>$ex,
                'response'=>'ko'
            ]);
        }
    }
}