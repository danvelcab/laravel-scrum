<?php 

namespace App\Http\Controllers;



class WelcomeController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      return view('welcome');
  }

  
}

?>