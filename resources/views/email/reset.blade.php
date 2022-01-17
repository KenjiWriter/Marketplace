<body class="bg-light">
    <div class="container">
      <div class="card p-6 p-lg-10 space-y-4">
        <h1 class="h3 fw-700">
          We received a request to reset your password.
        </h1>
        <p>
            Use the link below to reset your password, If You did not request to reset your password, ignore this email and the link will expire on its own.
        </p>
        <a class="btn btn-primary p-3 fw-700" href="{{ url('auth/reset/'. $user->email.'/'.$code) }}">Reset Password</a>
      </div>
    </div>
  </body>