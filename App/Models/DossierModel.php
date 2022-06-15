<?php
namespace App\Models;
use App\Core\Model;
class DossierModel extends Model{
    protected $isPK='idDOS';
    protected $isAI=true;
    
    var $idDOS,$nom_dossier,$notation;
    public function __construct(){
        parent::__construct();
    }
    

}
    