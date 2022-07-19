<?php
namespace App\Core;
class Model{
    var $db;
    var $table;
    public function __construct(){
        $this->db=Database::getConnection();
        $this->table=self::get_tablename();
    }
    
    public function getPPTS(){
        $ppts=get_object_vars($this);
        unset($ppts['db'],$ppts['table']);
        return $ppts;
    }


    public static function get_vars(){
        $ppts=get_class_vars(get_called_class());
        unset($ppts['db'],$ppts['table']);
        var_dump($ppts);
    }

    private static function get_tablename(){
        $ppts=get_class_vars(get_called_class());
        if (isset($ppts['table_name'])) {
            return strtolower($ppts['table_name']);
        } else {
            $mn=strtolower(get_called_class());
            $tab=explode('\\',$mn);
            return str_replace('model','',$tab[2]);
        }
        

    }

    public function getDESC()
    {
        $ppts=$this->getPPTS();
        var_dump($ppts);
    }

    public function tryParse($data)
    {
        $str="KEY ARRAY NOT FOUND\n";
        $str.="--------------------------------------------\n";
        $nbError=0;
        foreach ($data as $key => $value) {
            if (array_key_exists($key,$this)) {
                $this->{$key}=$value;
            }else{
                
                $str.="'".$key."' : '".$value."'\n";
                $str.="--------------------------------------------\n";
                $nbError++;
            }
        }
        if ($nbError>0) {
            echo nl2br($str);
        }
        
    }

    public function parse($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key,$this)) {
                $this->{$key}=$value;
            }
        }
        
    }

    public function insert($excludedPPTS=null) 
    {
        $ppts=$this->getPPTS();
        if(!isset($ppts['isPK'])){
            die('CLE PRIMARY NULL');
        }
        if(!isset($ppts['isAI'])){
            die('isAI NULL');
        }
        
        if($ppts['isAI']){
            $ik=$ppts['isPK'];
            unset($ppts[$ik]);
        }
        unset($ppts['isPK'],$ppts['isAI']);

        if(isset($excludedPPTS)){
            if(is_array($excludedPPTS)){
                foreach ($excludedPPTS as $value) {
                    unset($ppts[$value]);
                }
            }else{
                unset($ppts[$excludedPPTS]);
            }
        }
        $keys=array_keys($ppts);
        $alias=implode(',:',$keys);
        $alias=':'.$alias;
        $attr=implode(',',$keys);

        $tmp=explode(',',$attr);
        $values=array_values($ppts);
        $list=array_combine($tmp,$values);

        $sql='INSERT INTO '.$this->table.'('.$attr.') VALUES ('.$alias.');';
        try {
            $statement = $this->db->prepare($sql);
            if ($statement->execute($list)) {
                return isset($ik)?($this->db)->lastInsertId():'ok';
            } else {
                return 'ko';
            }
           
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
        
    }

    public function update($id=null,$excludedPPTS=null) 
    {
        $ppts=$this->getPPTS();
        if(!isset($ppts['isPK'])){
            die('CLE PRIMARY NULL');
        }
        if(!isset($ppts['isAI'])){
            die('isAI NULL');
        }

        $ik=$ppts['isPK'];
        unset($ppts['isPK'],$ppts['isAI']);

        if(isset($excludedPPTS)){
            if(is_array($excludedPPTS)){
                foreach ($excludedPPTS as $value) {
                    unset($ppts[$value]);
                }
            }else{
                unset($ppts[$excludedPPTS]);
            }
        }
        
        $keys=array_keys($ppts);
        $list=[];
        $ls=[];
        foreach ($ppts as $key => $value) {
            $ls[]=$key.'=:'.$key;
            $list[$key]=$ppts[$key];
        }
        
        $var1=implode(',',$ls);
        $sql='UPDATE '.$this->table.' SET '.$var1.' WHERE '.$ik.'=:idParam;';
        $list['idParam']=isset($id)?$id:$ppts[$ik];
        try {
            $statement = $this->db->prepare($sql);
            if ($statement->execute($list)) {
                return 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
        
    }

    public function delete() 
    {
        $ppts=$this->getPPTS();
        if(!isset($ppts['isPK'])){
            die('CLE PRIMARY NULL');
        }
        $ik=$ppts['isPK'];
        $sql='DELETE FROM '.$this->table.' WHERE '.$ik.'=:'.$ik.';';
        try {
            $statement = $this->db->prepare($sql);
            $cond=[
                $ik =>$ppts[$ik]
            ];
            if ($statement->execute($cond)) {
                return 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
        
    }

    public static function deleteBy($value){
        $table=self::get_tablename();
        $ppts=get_class_vars(get_called_class());
        $ik=$ppts['isPK'];
        $sql="DELETE FROM $table WHERE ".$ik.'=:'.$ik.';';
        $db=Database::getConnection();
        try {
            $stmt=$db->prepare($sql);
            if ($stmt->execute([$ik=>$value])) {
                return 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function getList($value=null,$order=null){
        $table=self::get_tablename();
        $sql='SELECT * FROM '.$table;
        if(isset($value) && isset($order)){
            $sql.=' ORDER BY '.$value.' '.$order;
        }
        $db=Database::getConnection();
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function get($value)
    {
        $table=self::get_tablename();
        $ppts=get_class_vars(get_called_class());

        if(!isset($ppts['isPK'])){
            die('CLE PRIMARY NULL');
        }

        if(!isset($ppts['isAI'])){
            die('isAI NULL');
        }
        $ik=$ppts['isPK'];
        
        $sql='SELECT * FROM '.$table.' WHERE '.$ik.'=?;';
        $db=Database::getConnection();
        try {
            $stmt = $db->prepare($sql);
            if($stmt->execute([$value])){
                return $stmt->fetch();
            }else{
                return false;
            }
        } catch (\PDOException $ex) {
            return false;
        }
    }


  
   

   
}