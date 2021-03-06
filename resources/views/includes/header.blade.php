<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/')}}/backend/assets/img/favicon.png?T={{time()}}">
    <link rel="icon" type="image/png" href="{{url('/')}}/backend/assets/img/favicon.png">
    <title>
      Dashboard
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{url('/')}}/backend/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{url('/')}}/backend/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{url('/')}}/backend/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
  </head>
{{-- <a class="nav-link text-dark"> Name: {{ ucfirst(Auth()->user()->name) }} </a><br/>
<a class="nav-link text-dark"> Email: {{ ucfirst(Auth()->user()->email) }} </a><br/>
<a class="nav-link text-dark"> Contact No.: {{ ucfirst(Auth()->user()->phone) }} </a><br/>
<a class="nav-link" href="{{ url('logout') }}"> Logout </a> --}}