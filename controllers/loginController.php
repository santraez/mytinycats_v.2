<?php
namespace Controller;
use MVC\router;
use Model\user;
use Class\email;
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
        $result = $user->validateUser();
        if ($result->num_rows) {
          $alerts = User::getAlerts();
        } else {
          // PASSWORD HASHER
          $user->hashPassword();
          // TOKEN GENERATOR
          $user->createToken();
          // SEND EMAIL
          $email = new Email($user->email, $user->display, $user->token);
          $email->sendConfirm();
          // CREATE USER
          $result = $user->save();
          if ($result) {
            header('Location: /message');
          }
          //debug($user);
        }
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
  public static function message(Router $router) {
    $router->render('auth/message');
  }
  public static function confirm(Router $router) {
    $alerts = [];
    $token = s($_GET['token']);
    $user = User::where('token', $token);
    if (empty($user)) {
      // SHOW ERROR MESSAGE
      User::setAlert('error', 'Invalid Token');
    } else {
      // MODIFY CONFIRMED USER
      $user->confirmed = '1';
      $user->token = null;
      $user->save();
      User::setAlert('success', 'Account Confirmed');
    }
    // OBTAIN ALERTS
    $alerts = User::getAlerts();
    // RENDER VIEWS
    $router->render('auth/confirm-account', [
      'alerts' => $alerts
    ]);
  }
}