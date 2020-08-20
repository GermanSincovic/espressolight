<?php
// NOT IN USE
/**
 * @table=users
 * @primary_key=user_id
 */
class User{

    public $user_id;
    public $account_id;
    public $role_id;
    public $branch_id;
    public $user_login;
    public $user_password;
    public $user_first_name;
    public $user_second_name;
    public $user_full_name;
    public $user_email;
    public $user_phone;
    public $user_comment;
    public $user_active;

    public function getUserId(){
        return $this->user_id;
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getAccountId(){
        return $this->account_id;
    }

    public function setAccountId($account_id){
        $this->account_id = $account_id;
    }

    public function getRoleId(){
        return $this->role_id;
    }

    public function setRoleId($role_id){
        $this->role_id = $role_id;
    }

    public function getBranchId(){
        return $this->branch_id;
    }

    public function setBranchId($branch_id){
        $this->branch_id = $branch_id;
    }

    public function getUserLogin(){
        return $this->user_login;
    }

    public function setUserLogin($user_login){
        $this->user_login = $user_login;
    }

    public function getUserPassword(){
        return $this->user_password;
    }

    public function setUserPassword($user_password){
        $this->user_password = $user_password;
    }

    public function getUserFirstName(){
        return $this->user_first_name;
    }

    public function setUserFirstName($user_first_name){
        $this->user_first_name = $user_first_name;
    }

    public function getUserSecondName(){
        return $this->user_second_name;
    }

    public function setUserSecondName($user_second_name){
        $this->user_second_name = $user_second_name;
    }

    public function getUserFullName(){
        return $this->user_full_name;
    }

    public function setUserFullName($user_full_name){
        $this->user_full_name = $user_full_name;
    }

    public function getUserEmail(){
        return $this->user_email;
    }

    public function setUserEmail($user_email){
        $this->user_email = $user_email;
    }

    public function getUserPhone(){
        return $this->user_phone;
    }

    public function setUserPhone($user_phone){
        $this->user_phone = $user_phone;
    }

    public function getUserComment(){
        return $this->user_comment;
    }

    public function setUserComment($user_comment){
        $this->user_comment = $user_comment;
    }

    public function getUserActive(){
        return $this->user_active;
    }

    public function setUserActive($user_active){
        $this->user_active = $user_active;
    }

}