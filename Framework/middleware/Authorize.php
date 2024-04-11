<?php 

namespace Framework\Middleware;

use Framework\Session;

class Authorize{
       /**
     * Check if user is authenticated
     * 
     * @return bool
     */

     public function isAuthenticated(){
        return Session::has('user');
     }

    /**
     * Handle the users reqeust 
     * 
     * @param string $role
     * 
     * @return bool
     */

     public function handle($role){
        if ($role === 'quest' && $this->isAuthenticated()) {
            return redirect('/Workopia/public');
        }elseif($role === 'auth' && !$this->isAuthenticated()){
            return redirect('/Workopia/public/login');
        }
     }
};