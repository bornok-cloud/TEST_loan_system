<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        
        #sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            height: 100vh;
            background: rgba(85, 9, 9, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            padding-top: 20px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }
        #sidebar.active {
            left: 0;
        }
        #sidebarToggle {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 1000;
        }
        #sidebar .nav-link {
            color: white;
            font-weight: bold;
            padding: 10px;
            transition: 0.3s;
        }
        #sidebar .nav-link:hover {
            background: rgba(80, 4, 4, 0.3);
            border-radius: 5px;
        }
        #sidebar h4 {
            color: rgb(199, 7, 7) ;
            padding-left: 8px;
            font-weight: bold;
        }
        #sidebarClose {
            float: right;
            color: white;
        }
    </style>
</head>

<div id="sidebar" class="p-3">
<h4>Dashboard <button id="sidebarClose" class="btn btn-outline-dark ">☰</button></h4> 
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="../../index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="../../LoginRegister/user/loan_types.php">Loan Types</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
        </ul>
       
    </div>