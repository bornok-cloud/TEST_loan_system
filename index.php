

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

-/* container sa home page */
        .custom-container {
                background-color:rgb(80, 18, 13);
                border-radius: 10px;
                padding: 20px;
                max-width: 900px;
                margin: auto;
            }
            .icon-text {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .icon-text i {
                color: green;
            }
            .promo-container {
                background-color: rgb(241, 241, 241);
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                border: 2px solid #dc3545; /* Bootstrap danger color */
            }
            @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
$main-green: #79dd09 !default;
$main-green-rgb-015: rgba(121, 221, 9, 0.1) !default;
$main-yellow: #bdbb49 !default;
$main-yellow-rgb-015: rgba(189, 187, 73, 0.1) !default;
$main-red: #bd150b !default;
$main-red-rgb-015: rgba(189, 21, 11, 0.1) !default;
$main-blue: #0076bd !default;
$main-blue-rgb-015: rgba(0, 118, 189, 0.1) !default;

/* This pen */
body {
	font-family: "Baloo 2", cursive;
	font-size: 16px;
	color: #ffffff;
	text-rendering: optimizeLegibility;
	font-weight: initial;
}

.dark {
	background: #110f16;
}


.light {
	background: #f3f5f7;
}

a, a:hover {
	text-decoration: none;
	transition: color 0.3s ease-in-out;
}

#pageHeaderTitle {
	margin: 2rem 0;
	text-transform: uppercase;
	text-align: center;
	font-size: 2.5rem;
}

/* Cards */
.postcard {
  flex-wrap: wrap;
  display: flex;
  
  box-shadow: 0 4px 21px -12px rgba(0, 0, 0, 0.66);
  border-radius: 10px;
  margin: 0 0 2rem 0;
  overflow: hidden;
  position: relative;
  color: #ffffff;

	&.dark {
		background-color:rgb(255, 255, 255);
	}
	&.light {
		background-color:rgb(255, 255, 255);
	}
	
	.t-dark {
		color:rgb(0, 0, 0);
	}
	
  a {
    color: inherit;
  }
	
	h1,	.h1 {
		margin-bottom: 0.5rem;
		font-weight: 500;
		line-height: 1.2;
	}
	
	.small {
		font-size: 80%;
	}

  .postcard__title {
    font-size: 1.75rem;
  }

  .postcard__img {
    max-height: 180px;
    width: 100%;
    object-fit: cover;
    position: relative;
  }

  .postcard__img_link {
    display: contents;
  }

  .postcard__bar {
    width: 50px;
    height: 10px;
    margin: 10px 0;
    border-radius: 5px;
    background-color:rgb(255, 0, 0);
    transition: width 0.2s ease;
  }

  .postcard__text {
    padding: 1.5rem;
    position: relative;
    display: flex;
    flex-direction: column;
  }

  .postcard__preview-txt {
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: justify;
    height: 100%;
  }

  .postcard__tagbox {
    display: flex;
    flex-flow: row wrap;
    font-size: 14px;
    margin: 20px 0 0 0;
		padding: 0;
    justify-content: center;

    .tag__item {
      display: inline-block;
      background: rgba(83, 83, 83, 0.4);
      border-radius: 3px;
      padding: 2.5px 10px;
      margin: 0 5px 5px 0;
      cursor: default;
      user-select: none;
      transition: background-color 0.3s;

      &:hover {
        background: rgba(83, 83, 83, 0.8);
      }
    }
  }

  &:before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: linear-gradient(-70deg, #424242, transparent 50%);
    opacity: 1;
    border-radius: 10px;
  }

  &:hover .postcard__bar {
    width: 100px;
  }
}

@media screen and (min-width: 769px) {
  .postcard {
    flex-wrap: inherit;

    .postcard__title {
      font-size: 2rem;
    }

    .postcard__tagbox {
      justify-content: start;
    }

    .postcard__img {
      max-width: 300px;
      max-height: 100%;
      transition: transform 0.3s ease;
    }

    .postcard__text {
      padding: 3rem;
      width: 100%;
    }

    .media.postcard__text:before {
      content: "";
      position: absolute;
      display: block;
      background: #18151f;
      top: -20%;
      height: 130%;
      width: 55px;
    }

    &:hover .postcard__img {
      transform: scale(1.1);
    }

    &:nth-child(2n+1) {
      flex-direction: row;
    }

    &:nth-child(2n+0) {
      flex-direction: row-reverse;
    }

    &:nth-child(2n+1) .postcard__text::before {
      left: -12px !important;
      transform: rotate(4deg);
    }

    &:nth-child(2n+0) .postcard__text::before {
      right: -12px !important;
      transform: rotate(-4deg);
    }
  }
}
@media screen and (min-width: 1024px){
		.postcard__text {
      padding: 2rem 3.5rem;
    }
		
		.postcard__text:before {
      content: "";
      position: absolute;
      display: block;
      
      top: -20%;
      height: 130%;
      width: 55px;
    }
	
  .postcard.dark {
		.postcard__text:before {
			background:rgb(223, 223, 223);
		}
  }
	.postcard.light {
		.postcard__text:before {
			background: #e1e5ea;
		}
  }
}

/* COLORS */
.postcard .postcard__tagbox .green.play:hover {
	background: $main-green;
	color: black;
}
.green .postcard__title:hover {
	color: $main-green;
}
.green .postcard__bar {
	background-color: $main-green;
}
.green::before {
	background-image: linear-gradient(
		-30deg,
		$main-green-rgb-015,
		transparent 50%
	);
}
.green:nth-child(2n)::before {
	background-image: linear-gradient(30deg, $main-green-rgb-015, transparent 50%);
}

.postcard .postcard__tagbox .blue.play:hover {
	background: $main-blue;
}
.blue .postcard__title:hover {
	color: $main-blue;
}
.blue .postcard__bar {
	background-color: $main-blue;
}
.blue::before {
	background-image: linear-gradient(-30deg, $main-blue-rgb-015, transparent 50%);
}
.blue:nth-child(2n)::before {
	background-image: linear-gradient(30deg, $main-blue-rgb-015, transparent 50%);
}

.postcard .postcard__tagbox .red.play:hover {
	background: $main-red;
}
.red .postcard__title:hover {
	color: $main-red;
}
.red .postcard__bar {
	background-color: $main-red;
}
.red::before {
	background-image: linear-gradient(-30deg, $main-red-rgb-015, transparent 50%);
}
.red:nth-child(2n)::before {
	background-image: linear-gradient(30deg, $main-red-rgb-015, transparent 50%);
}

.postcard .postcard__tagbox .yellow.play:hover {
	background: $main-yellow;
	color: black;
}
.yellow .postcard__title:hover {
	color: $main-yellow;
}
.yellow .postcard__bar {
	background-color: $main-yellow;
}
.yellow::before {
	background-image: linear-gradient(
		-30deg,
		$main-yellow-rgb-015,
		transparent 50%
	);
}
.yellow:nth-child(2n)::before {
	background-image: linear-gradient(
		30deg,
		$main-yellow-rgb-015,
		transparent 50%
	);
}

@media screen and (min-width: 769px) {
	.green::before {
		background-image: linear-gradient(
			-80deg,
			$main-green-rgb-015,
			transparent 50%
		);
	}
	.green:nth-child(2n)::before {
		background-image: linear-gradient(
			80deg,
			$main-green-rgb-015,
			transparent 50%
		);
	}

	.blue::before {
		background-image: linear-gradient(
			-80deg,
			$main-blue-rgb-015,
			transparent 50%
		);
	}
	.blue:nth-child(2n)::before {
		background-image: linear-gradient(80deg, $main-blue-rgb-015, transparent 50%);
	}

	.red::before {
		background-image: linear-gradient(-80deg, $main-red-rgb-015, transparent 50%);
	}
	.red:nth-child(2n)::before {
		background-image: linear-gradient(80deg, $main-red-rgb-015, transparent 50%);
	}
	
	.yellow::before {
		background-image: linear-gradient(
			-80deg,
			$main-yellow-rgb-015,
			transparent 50%
		);
	}
	.yellow:nth-child(2n)::before {
		background-image: linear-gradient(
			80deg,
			$main-yellow-rgb-015,
			transparent 50%
		);
	}
}

-/* container sa home page */
        .custom-container {
            background-color:rgb(80, 18, 13);
            border-radius: 10px;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }
        .icon-text {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .icon-text i {
            color: green;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Basic Bootstrap-like Styles */

/* Root Variables */
:root {
  --bs-primary: #0d6efd;
  --bs-secondary: #6c757d;
  --bs-success: #198754;
  --bs-danger: #dc3545;
  --bs-warning: #ffc107;
  --bs-info: #0dcaf0;
  --bs-light: #f8f9fa;
  --bs-dark: #212529;
  --bs-white: #fff;
  --bs-black: #000;
  --bs-body-font-family: Arial, sans-serif;
}

/* Basic Typography */
body {
  font-family: var(--bs-body-font-family);
  font-size: 1rem;
  color: var(--bs-dark);
  background-color: var(--bs-light);
}

h1, h2, h3, h4, h5, h6 {
  font-weight: bold;
}

/* Navigation Links */
.nav-link {
  text-decoration: none;
  color: var(--bs-dark);
  padding: 0.5rem 1rem;
  transition: 0.3s;
}

.nav-link:hover {
  background-color: var(--bs-danger);
  color: var(--bs-white);
  border-radius: 0.375rem;
}

/* Buttons */
.btn {
  display: inline-block;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  text-decoration: none;
  cursor: pointer;
  text-align: center;
  border: none;
  transition: 0.3s;
}

.btn-primary {
  background-color: var(--bs-primary);
  color: var(--bs-white);
}

.btn-primary:hover {
  background-color: #0b5ed7;
}

.btn-secondary {
  background-color: var(--bs-secondary);
  color: var(--bs-white);
}

.btn-secondary:hover {
  background-color: #5a6268;
}

.btn-success {
  background-color: var(--bs-success);
  color: var(--bs-white);
}

.btn-success:hover {
  background-color: #157347;
}

.btn-danger {
  background-color: var(--bs-danger);
  color: var(--bs-white);
}

.btn-danger:hover {
  background-color: #bb2d3b;
}

/* Grid System */
.container {
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}

.col {
  flex: 1;
  padding-right: 15px;
  padding-left: 15px;
}

/* Cards */
.card {
  border: 1px solid #ddd;
  border-radius: 0.5rem;
  padding: 1rem;
  box-shadow: 0 2px 4px rgb(255, 0, 0);
  background-color: var(--bs-white);
  transition: transform 0.3s;
}

.card:hover {
  transform: scale(1.02);
}

.card-header {
  font-weight: bold;
  background-color: var(--bs-light);
  padding: 0.75rem;
  border-bottom: 1px solid #ddd;
}

.card-body {
  padding: 1rem;
}

/* Tables */
.table {
  width: 100%;
  border-collapse: collapse;
}

.table th, .table td {
  padding: 0.75rem;
  border: 1px solid #ddd;
}

.table tbody tr:hover {
  background-color: #f1f1f1;
}

/* Forms */
.form-control {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 0.375rem;
  transition: border-color 0.3s;
}

.form-control:focus {
  border-color: var(--bs-primary);
  outline: none;
}

/* Alerts */
.alert {
  padding: 1rem;
  border-radius: 0.375rem;
  margin-bottom: 1rem;
  transition: opacity 0.3s;
}

.alert-primary {
  background-color: var(--bs-primary);
  color: var(--bs-white);
}

.alert-primary:hover {
  background-color: #0b5ed7;
}

.alert-danger {
  background-color: var(--bs-danger);
  color: var(--bs-white);
}

.alert-danger:hover {
  background-color: #bb2d3b;
}
/* Add this to your existing styles */
.valid-id-modal .modal-header {
            background-color: #dc3545;
            color: white;
        }
        .valid-id-list {
            list-style-type: none;
            padding-left: 0;
        }
        .valid-id-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .valid-id-list li:last-child {
            border-bottom: none;
        }
        .valid-id-category {
            font-weight: bold;
            color: #dc3545;
            margin-top: 15px;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <button id="sidebarToggle" class="btn btn-outline-dark">☰</button>
            <a class="navbar-brand text-danger fw-bold ms-4" href="#">UNIQLOAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Loans Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item">
                        <a class="btn btn-danger ms-4" href="#">Payment</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <!-- sa home page ulit -->
    <div class="container my-5">
    <div class="row align-items-center promo-container mb-4">
        <div class="col-md-6">
            <h3>Why choose Uniqloan for your loans?</h3>
            <ul class="check-list">
                <li>Low Interest Rate & monthly rates</li>
                <li>Flexible payment options</li>
                <li>Fast & easy application process</li>
            </ul>
            <button class="btn btn-success">About Us</button>
        </div>
        <div class="col-md-6">
            <img src="img/BANNER1.jpg" class="img-fluid rounded" alt="Home Credit Assistance">
        </div>
    </div>

    <!-- Cash Loan Section -->
    <div class="row align-items-center promo-container">
        <div class="col-md-6">
            <h3>Why choose Uniqloan for your cash loans?</h3>
            <ul class="check-list">
                <li>Instant cash disbursement</li>
                <li>Flexible repayment terms</li>
                <li>Easy online application</li>
            </ul>
            <a href="LoginRegister/user/calculator.php" class="btn btn-danger">Apply for Cash Loan</a>

        </div>
        <div class="col-md-6">
            <img src="img/SLIDER2.jpg" class="img-fluid rounded" alt="Cash Loan Assistance">
        </div>
    </div>
</div>
<!--section e -->
<section class="light">
	<div class="container py-2">
    <h5 class="text-danger text-center"> Uniqloan Requirements</h5>
		<div class="h1 text-center text-dark" id="pageHeaderTitle">Basic Requirement to apply</div>

		<article class="postcard light blue">
        <a class="postcard__img_link" href="#">
            <img class="postcard__img" src="img/ID.jpg" alt="Image Title" />
        </a>
        <div class="postcard__text t-dark">
            <h1 class="postcard__title blue">
                <a href="#" data-bs-toggle="modal" data-bs-target="#validIdModal">Valid ID</a>
            </h1>
            <div class="postcard__preview-txt mt-5">Must have one primary ID that contains your current address.</div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#validIdModal">
                <i class="fas fa-play mr-2"></i>View list of ID
            </a>
        </div>
    </article>
    <!-- Valid ID Modal -->
    <div class="modal fade" id="validIdModal" tabindex="-1" aria-labelledby="validIdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content valid-id-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="validIdModalLabel">List of Accepted Valid IDs</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="valid-id-category">Primary Government-Issued IDs</h6>
                            <ul class="valid-id-list">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Passport</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Driver's License</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Senior Citizen's ID</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>PWD ID Card</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>PhilHealth ID</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Postal ID</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <!-- <h6 class="valid-id-category">Secondary Supporting Documents</h6>
                            <ul class="valid-id-list">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Barangay Clearance</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Police Clearance</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Voter's ID</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Company ID (for employed applicants)</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>School ID (for students)</li>
                            </ul> -->
                            
                            <h6 class="valid-id-category mt-4">Requirements</h6>
                            <ul class="valid-id-list">
                                <li><i class="bi bi-exclamation-circle-fill text-warning me-2"></i>ID must be valid and not expired</li>
                                <li><i class="bi bi-exclamation-circle-fill text-warning me-2"></i>Must contain your photo and signature</li>
                                <li><i class="bi bi-exclamation-circle-fill text-warning me-2"></i>Must show your current address</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">I Understand</button>
                </div>
            </div>
        </div>
    </div>
		<article class="postcard light red">
			<a class="postcard__img_link" href="#">
				<img class="postcard__img" src="img/PINOY.jpg" alt="Image Title" />	
			</a>
			<div class="postcard__text t-dark">
				<h1 class="postcard__title red ms-5"><a href="#">Filipino Citizen</a></h1>
				<div class="postcard__preview-txt ms-5 mt-5">Must be a Filipino Citizen, age 21-60 years old</div>
			</div>
		</article>
		<article class="postcard light green">
			<a class="postcard__img_link" href="#">
				<img class="postcard__img" src="img/PINESO.png" alt="Image Title" />
			</a>
			<div class="postcard__text t-dark">
				<h1 class="postcard__title green"><a href="#">Source of Income</a></h1>
				<div class="postcard__preview-txt mt-5">Must have an income from reliable sources such as employment, business, pension, and remittances.</div>
			</div>
		</article>
		     
	</div>
</section>
</div>
<div id="sidebar" class="p-3">
<h4>Dashboard <button id="sidebarClose" class="btn btn-outline-dark ">☰</button></h4> 
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="LoginRegister/user/loan_types.php">Loan Types</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
            <hr class="my-3">
            <h5 class="mt-0 text-danger"> Account </h5>
            <li><a class="nav-item"><a class="nav-link" href="LoginRegister/user/login.php">Login</a></li>
            <li><a class="nav-item"><a class="nav-link" href="LoginRegister/user/registration.php">Register</a></li>
            <hr class="my-3">
          </ul>
       
    </div>    
     <!-- Make sure you have Bootstrap JS included -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <?php include('includes/footer.php')?>   
    <?php include('includes/script.php')?>      
</body>
</html>


