<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>ESCEO - Dashboard</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="{{ asset($basePath . '/images/favicon.ico') }}" type="image/x-icon" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset($basePath . '/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/style.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/css/colors.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/css/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/css/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset($basePath . '/css/settings.css') }}" /> 
    <link rel="stylesheet" href="{{ asset($basePath . '/css/calendar.css') }}" />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body class="dashboard dashboard_1">

    <div class="full_container">
        <div class="inner_container">
