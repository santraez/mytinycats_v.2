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
          // ADD DATE
          $user->created = date('Y-m-d H:i:s');
          // SEND EMAIL
          $email = new Email($user->email, $user->display, $user->token);
          $email->sendConfirm();
          // CREATE USER
          $result = $user->save();
          if ($result) {
            header('Location: /message');
          }
        }
      }
    }
    $router->render('auth/signup', [
      'user'=>$user,
      'alerts'=>$alerts
    ]);
  }
  public static function login(Router $router) {
    $alerts = [];
    $auth = new User;
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new User($_POST);
      $alerts = $auth->validateLogin();
      if(empty($alerts)) {
        // CHECK USER EXIST
        $user = User::where('email', $auth->email);
        if($user) {
          // CHECK PASSWORD
          if($user->checkPasswordAndVerified($auth->password)) {
            //AUTHENTICATE USER
            session_start();
            $_SESSION['id'] = $user->id;
            $_SESSION['display'] = $user->display;
            $_SESSION['email'] = $user->email;
            $_SESSION['login'] = true;
            // REDIRECT
            if($user->admin === '1') {
              $_SESSION['admin'] = $user->admin ?? null;
              header('Location: /admin');
            } else {
              header('Location: /resources');
            }
          }
        } else {
          User::setAlert('error', 'user not exist');
        }
      }
    }
    $alerts = User::getAlerts();
    $router->render('auth/login', [
      'alerts' => $alerts,
      'auth' => $auth
    ]);
  }
  public static function logout() {
    echo 'logout';
  }
  public static function forgotPassword(Router $router) {
    $alerts = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new User($_POST);
      $alerts = $auth->validateEmail();
      if(empty($alerts)) {
        $user = User::where('email', $auth->email);
        if($user && $user->confirmed === '1') {
          // GENERATE TOKEN
          $user->createToken();
          $user->save();
          // SEND EMAIL
          $email = new Email($user->email, $user->display, $user->token);
          $email->sendInstructions();
          // SUCCESS MESSAGE
          User::setAlert('success', 'We send you a email to update');
        } else {
          // ERROR MESSAGE
          User::setAlert('error', 'User not exist or It\'s not confirmed');
        }
      }
    }
    $alerts = User::getAlerts();
    $router->render('auth/forgot-password', [
      'alerts' => $alerts
    ]);
  }
  public static function recoverPassword(Router $router) {
    $alerts = [];
    $error = false;
    $token = s($_GET['token']);
    // SEARCH USER FOR TOKEN
    $user = User::where('token', $token);
    if(empty($user)) {
      User::setAlert('error', 'Invalid Token');
      $error = true;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      // READ NEW PASSWORD AND SAVE
      $password = new User($_POST);
      $alerts = $password->validatePassword();
      if(empty($alerts)) {
        $user->password = null;
        $user->password = $password->password;
        $user->hashPassword();
        $user->token = null;
        $result = $user->save();
        if($result) {
          header('Location: /login');
        }
      }
    }
    $alerts = User::getAlerts();
    $router->render('auth/recover-password', [
      'alerts' => $alerts,
      'error' => $error
    ]);
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