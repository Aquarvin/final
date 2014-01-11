<?php
class WebUser extends CWebUser {
    private $_model = null;
 
    function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->role;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
            if (empty($this->_model));
            {
                $this->_model=User::model()->findByPk(1, array('select' => 'role'));
            }
            // echo var_dump($this->_model); die;
        }
        return $this->_model;
    }
}
?>