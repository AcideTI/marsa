
<body class="fondoLogin">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4"><img class="imagenLogin" src="view/img/logo-marsa.png" ></h3>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputUser" type="text" name="inputUser" placeholder="Usuario" />
                      <label for="inputUser"></label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputPassword" type="password" name="inputPassword" placeholder="Contraseña" />
                      <label for="inputPassword"></label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button class="btn btn-light" type="submit">Ingresar</button>
                    </div>
                    <?php
                      $login = new UsersController();
                      $login -> ctrLogIn();
                    ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>