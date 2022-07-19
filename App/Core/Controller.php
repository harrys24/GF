<?php
namespace App\Core;
class Controller{
    var $layout='default';
    var $dir_view;
    var $dir_template=APP.'/Views/Templates/';
    var $content;
    public function __construct(){
        $tmp=str_replace('Controller','View',get_class($this));
        $this->dir_view=APP.'/Views/'.$tmp.'/';
    }

    public function render($filename, $data = null){
        if($data){extract($data);}
        $_tmp=str_replace('.','/',$filename);
        $_tmp=explode('/',$_tmp);
        if (count($_tmp)>1) {
            $_nv=ucfirst($_tmp[0]).'View/';
            unset($_tmp[0]);
            $_nf=implode('/',$_tmp);
            require APP.'/Views/'.$_nv.$_nf.'.php';
        } else {
            require $this->dir_view.$filename.'.php';
        }
    }

    public function template($filename, $data = null){
        if($data){
            extract($data);
        }
        require $this->dir_template.$filename.'.php';
    }

    public function _renderH($data = null){
        if($data){
            extract($data);
        }
        require APP.'/Views/Layout/header.php';
    }

    public function renderH($data = null){
        if($data){
            extract($data);
        }
        require APP.'/Views/Layout/header.php';
        require APP.'/Views/Layout/menu.php';
    }
    public function renderF($data = null){
        if($data){
            extract($data);
        }
        require APP.'/Views/Layout/footer.php';
    }
    
    public function renderOB($filename, $data = null){
        if($data){
            extract($data);
        }
        ob_start();
        require $this->dir_view.$filename.'.php';
        return ob_get_clean();
    }


}