<?php
namespace source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;

class User extends DataLayer
{
    
    
    public function __construct()
    {
        // Definindo parâmetros
        parent::__construct("USERS", ["FNAME", "IDTYPE", "LNAME", "PHONE", "EMAIL", "PASSWORD"], "IDUSER", false);
    }
   
    /**
     * {@inheritDoc}
     * @see \CoffeeCode\DataLayer\DataLayer::save()
     */
    public function save(): bool
    {
        if (!$this->validateEmail() || !$this->validatePassword() || !parent::save()){
            return false;
        }
        
        return true;
        
        
    }
    
    /**
     * @return bool
     */
    protected function validateEmail(): bool
    {   
        if (empty($this->EMAIL) || !filter_var($this->EMAIL, FILTER_VALIDATE_EMAIL)) {
            $this->fail = new Exception("Informe um email válido");
            return false;
        }
        
        $userByEmail = null;
        if (!$this->IDUSER) {
            $userByEmail = $this->find("email = :email", "email=($this->EMAIL = :email)")->count();
        } else {
            $userByEmail = $this->find("email = :email AND IDUSER != :id", "EMAIL=($this->EMAIL)&IDUSER=($this->IDUSER)")->count();
        }
        
        if ($userByEmail) {
            $this->fail = new Exception("Esse email já foi cadastrado");
            return false;
        }
        
        return true;
    }
    
    /**
     * @return bool
     */
    protected function validatePassword(): bool
    {
        if (empty($this->PASSWORD) || strlen($this->PASSWORD) < 5) {
            $this->fail = new Exception("Informe uma senha com pelo menos 5 caracteres");
            return false;
        } 
        
        if (password_get_info($this->PASSWORD)["algo"]) {
            return true;
        }
        
        $this->PASSWORD = password_hash($this->PASSWORD, PASSWORD_DEFAULT);
        return true;
    }
}