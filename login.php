<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
    
<section class="vh-100" style="background-color: #0a1473;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Sign in</h3>

            <div data-mdb-input-init class="form-outline mb-4">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" id="typeEmailX-2" class="form-control form-control-lg" />
              </div>
              <label class="form-label" for="typeEmailX-2">Email</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" />
              </div>
              <label class="form-label" for="typePasswordX-2">Password</label>
            </div>

            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-start mb-4">
              <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
              <label class="form-check-label" for="form1Example3"> Remember password </label>
            </div>

            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

            <hr class="my-4">

            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary mb-3" style="background-color: #dd4b39;"
              type="submit"><i class="fab fa-google me-2"></i> Sign in with Google</button>
            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary" style="background-color: #3b5998;"
              type="submit"><i class="fab fa-facebook-f me-2"></i> Sign in with Facebook</button>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>