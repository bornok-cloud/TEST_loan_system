<style>
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

</style>

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
                    <li class="nav-item "><a class="nav-link" href="">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Loans Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item">
                        <a class="btn btn-danger ms-4" href="#">Payment</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark dropdown-toggle ms-1" href="#" role="button" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Login</a></li>
                            <li><a class="dropdown-item" href="#">Register</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>