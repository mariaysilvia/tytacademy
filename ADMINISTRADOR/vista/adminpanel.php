<?php include '../vista/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
<main>
      <div class="imagenTYT">
        <img src="../publico/imagenesadmin/tytacademy.png" alt="">
      </div>
        <div class="insights">

        <!-- las ultimas pruebas -->
            <div class="sales">
            <span class="material-symbols-sharp">unarchive</span>
            <div class="middle">

                <div class="left">
                <h3>Pruebas subidas</h3>
                <h1>10 pruebas</h1>
            </div>
                <div class="progress">
                    <svg>
                    <circle  r="30" cy="40" cx="40"></circle>
                    </svg>
                    <div class="number"><p>200</p></div>
                </div>

            </div>
            <small>Las últimas 24 horas </small>
            </div>

            <!-- los ultimos instructores -->
            <div class="expenses">
                <span class="material-symbols-sharp">open_in_browser</span>
                <div class="middle">

                <div class="left">
                    <h3>Instructores</h3>
                    <h1>12 en lista</h1>
                </div>
                <div class="progress">
                      <svg>
                          <circle  r="30" cy="40" cx="40"></circle>
                      </svg>
                      <div class="number"><p>45%</p></div>
                  </div>

                </div>
                <small>Las últimas 24 horas</small>
            </div>


              <!-- los ultimos aprendices-->
              <div class="income">
                <span class="material-symbols-sharp">trackpad_input</span>
                <div class="middle">

                  <div class="left">
                    <h3>Aprendices</h3>
                    <h1>15 en lista</h1>
                  </div>
                  <div class="progress">
                      <svg>
                          <circle  r="30" cy="40" cx="40"></circle>
                      </svg>
                      <div class="number"><p>70%</p></div>
                  </div>

                </div>
                <small>Las últimas 24 horas</small>
            </div>


        </div>

      <div class="recent_order">
        <h2>Recientes pruebas presentadas</h2>
        <table> 
            <thead>
              <tr>
                <th>Modulo TYT </th>
                <th>Número pruebas</th>
                <th>Número de preguntas</th>
                <th>Estado de los aprendices</th>
              </tr>
            </thead>
              <tbody>
                <tr>
                  <td><strong>Lectura Crítica</strong></td>
                  <td>10</td>
                  <td>20</td>
                  <td class="warning">Falla</td>
                  <td class="primary">Aprobado</td>
                </tr>
                <tr>
                  <td><strong>Razonamiento Cuantitativo</strong></td>
                  <td>10</td>
                  <td>20</td>
                  <td class="warning">Falla</td>
                  <td class="primary">Aprobado</td>
                </tr>
                <tr>
                  <td><strong>Competencia Ciudadana</strong></td>
                  <td>10</td>
                  <td>20</td>
                  <td class="warning">Falla</td>
                  <td class="primary">Aprobado</td>
                </tr>
                <tr>
                  <td><strong>Comunicación</strong></td>
                  <td>10</td>
                  <td>20</td>
                  <td class="warning">Falla</td>
                  <td class="primary">Aprobado</td>
                </tr>
                <tr>
                  <td><strong>Inglés</strong></td>
                  <td>10</td>
                  <td>20</td>
                  <td class="warning">Falla</td>
                  <td class="primary">Aprobado</td>
                </tr>

              </tbody>
        </table>
      </div>

      </main>

    <div class="right">

<div class="top">
  <button id="menu_bar">
    <span class="material-symbols-sharp">menu</span>
  </button>

  <div class="theme-toggler">
    <span class="material-symbols-sharp active">light_mode</span>
    <span class="material-symbols-sharp">dark_mode</span>
  </div>
    <div class="profile">
      <div class="info">
          <p><b>TYTACADEMY</b></p>
          <p>Administrador</p>
          <small class="text-muted"></small>
      </div>
      <div class="profile-photo">
        <img src="../publico/imagenesadmin/administracion-1.jpg" alt=""/>
      </div>
    </div>
</div>

  <div class="recent_updates">
    <h2>Recientemente</h2>
  <div class="updates">
      <div class="update">
        <div class="profile-photo">
            <img src="../publico/imagenesadmin/administracion-3.jpg" alt=""/>
        </div>
        <div class="message">
          <p><b>Lectura Crítica</b><br>5 preguntas adicionales</p>
        </div>
      </div>
      <div class="update">
        <div class="profile-photo">
        <img src="../publico/imagenesadmin/administracion-4.jpg" alt=""/>
        </div>
      <div class="message">
          <p><b>Inglés</b><br>10 preguntas corregidas</p>
      </div>
    </div>
    <div class="update">
      <div class="profile-photo">
        <img src="../publico/imagenesadmin/administracion-5.jpg" alt=""/>
      </div>
    <div class="message">
        <p><b>Razonamiento Cuantitativo</b> 1 prueba nueva subida</p>
    </div>
  </div>
  </div>
  </div>


  <div class="sales-analytics">
    <h2>Estadísticas</h2>

      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">trending_down</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Incorrectas</h3>
            <small class="text-muted">10 preguntas</small>

          </div>
          <h5 class="danger">-17%</h5>
          <h3>321</h3>
        </div>
      </div>
      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">trending_up</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Aprobadas</h3>
            <small class="text-muted">15 preguntas</small>
          </div>
          <h5 class="success">+25%</h5>
          <h3>251</h3>
        </div>
      </div>
      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">query_stats</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Corregidas</h3>
            <small class="text-muted">+20preguntas</small>
          </div>
          <h5 class="danger">60%</h5>
          <h3>3849</h3>
        </div>
      </div>
</div>
</body>
</html>