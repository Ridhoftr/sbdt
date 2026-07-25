<?php
if (!isset($page)) {
    $page = "";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CleanWash Laundry Management</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet"
    href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- DataTables Responsive -->
    <link rel="stylesheet"
    href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#f5f7fb;
            overflow-x:hidden;
        }

        a{
            text-decoration:none;
        }

        /* =======================
           SIDEBAR
        ======================= */

        .sidebar{

            position:fixed;

            top:0;

            left:0;

            width:260px;

            height:100vh;

            background:#0d6efd;

            color:white;

            padding-top:20px;

            box-shadow:3px 0 10px rgba(0,0,0,.15);

            z-index:1000;

        }

        .sidebar h3{

            text-align:center;

            margin-bottom:30px;

            font-weight:bold;

        }

        .sidebar a{

            color:white;

            display:block;

            padding:14px 25px;

            transition:.3s;

        }

        .sidebar a:hover{

            background:rgba(255,255,255,.15);

            padding-left:35px;

        }

        .sidebar .active{

            background:white;

            color:#0d6efd;

            font-weight:bold;

            border-radius:0 30px 30px 0;

            margin-right:15px;

        }

        /* =======================
            TOPBAR
        ======================= */

        .topbar{

            margin-left:260px;

            height:70px;

            background:white;

            display:flex;

            align-items:center;

            justify-content:space-between;

            padding:0 30px;

            box-shadow:0 2px 10px rgba(0,0,0,.08);

        }

        /* =======================
            CONTENT
        ======================= */

        .content{

            margin-left:260px;

            padding:30px;

        }

        /* =======================
            CARD
        ======================= */

        .card-dashboard{

            border:none;

            border-radius:18px;

            box-shadow:0 5px 15px rgba(0,0,0,.08);

            transition:.3s;

        }

        .card-dashboard:hover{

            transform:translateY(-5px);

        }

        .card-icon{

            font-size:35px;

        }

        footer{

            margin-left:260px;

            padding:20px;

            text-align:center;

            color:#777;

        }

        @media(max-width:992px){

            .sidebar{

                width:70px;

            }

            .sidebar h3{

                display:none;

            }

            .sidebar a{

                text-align:center;

                padding:18px;

            }

            .sidebar a span{

                display:none;

            }

            .topbar{

                margin-left:70px;

            }

            .content{

                margin-left:70px;

            }

            footer{

                margin-left:70px;

            }

        }

        /* =======================
        DATATABLES
        ======================= */

        .dt-buttons{

            margin-bottom:15px;

        }

        .dt-button{

            margin-right:5px !important;

        }

        .dataTables_filter{

            margin-bottom:15px;

        }

        .dataTables_length{

            margin-bottom:15px;

        }

    </style>

</head>

<body>