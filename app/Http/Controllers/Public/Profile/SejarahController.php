<?php

namespace App\Http\Controllers\Public\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
  public function index()
  {
    return view('public.profile.sejarah.index');
  }
}
