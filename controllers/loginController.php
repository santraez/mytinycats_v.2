<?php
namespace Controller;
use MVC\router;
use Model\user;
class LoginController {
  public static function home(Router $router) {
    $router->render('home');
  }
  public static function signup(Router $router) {
    $user = new User;
    // EMPTY ALERTS
    $alerts = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->sync($_POST);
      $alerts = $user->validateNewAccount();
      // CHECK IF ALERTS IS EMPTY
      if(empty($alerts)) {
        // CHECK IF DISPLAY IS ALREADY IN USE
        // CHECK IF EMAIL IS ALREADY IN USE
      }
    }
    $router->render('auth/signup', [
      'user'=>$user,
      'alerts'=>$alerts
    ]);
  }
  public static function login(Router $router) {
    $router->render('auth/login');
  }
  public static function logout() {
    echo 'logout';
  }
  public static function forgotPassword(Router $router) {
    $router->render('auth/forgot-password', [
      
    ]);
  }
  public static function recoverPassword() {
    echo 'recover password';
  }
}