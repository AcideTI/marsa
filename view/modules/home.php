</div>
</div>
<div class="sb-sidenav-footer">
  <div class="small">Sesión iniciada como:</div>
  <?php echo $_SESSION["Nombre"] ?>
</div>
</nav>
</div>

<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <!-- Header del Dashboard -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0"><i class="fa-solid fa-chart-line text-primary me-2"></i>Dashboard</h1>
          <p class="text-muted mb-0">Bienvenido al panel de control del sistema</p>
        </div>
        <div class="text-end">
          <span class="text-muted"><i class="fa-solid fa-calendar me-1"></i><?php echo date("d/m/Y"); ?></span>
        </div>
      </div>

      <!-- Cards de navegación rápida -->
      <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-info text-white mb-4 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-shopping-cart fa-3x opacity-75"></i>
                <div class="text-end">
                  <h4 class="mb-0">Pedidos</h4>
                  <small class="opacity-75">Gestionar salidas</small>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="verSalidas">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
          <div class="card bg-warning text-white mb-4 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-box fa-3x opacity-75"></i>
                <div class="text-end">
                  <h4 class="mb-0">Inventario</h4>
                  <small class="opacity-75">Stock almacén</small>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="almacen">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>
      
        <div class="col-xl-3 col-md-6">
          <div class="card bg-success text-white mb-4 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-box-open fa-3x opacity-75"></i>
                <div class="text-end">
                  <h4 class="mb-0">Ingresos</h4>
                  <small class="opacity-75">Producción</small>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="ingresos">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>
       
        <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-users fa-3x opacity-75"></i>
                <div class="text-end">
                  <h4 class="mb-0">Clientes</h4>
                  <small class="opacity-75">Directorio</small>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="clients">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>
      </div>

      <!-- KPI 1: Gráfico de Inventario -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning py-3">
          <h5 class="mb-0"><i class="fa-solid fa-warehouse me-2"></i>Stock de Inventario - Top Productos</h5>
        </div>
        <div class="card-body">
          <div style="height: 400px;">
            <canvas id="chartInventario"></canvas>
          </div>
          <div class="mt-2 text-center">
            <small class="text-muted">
              <span class="badge bg-success me-1">&nbsp;</span>Positivo (Stock disponible)
              <span class="badge bg-danger ms-2 me-1">&nbsp;</span>Negativo (Falta stock)
            </small>
          </div>
        </div>
      </div>

      <!-- KPI 2: Gráfico de Notas de Pedido por Semana -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
          <h5 class="mb-0"><i class="fa-solid fa-chart-area me-2"></i>Notas de Pedido - Últimos 3 Meses (Por Semana)</h5>
        </div>
        <div class="card-body">
          <div style="height: 350px;">
            <canvas id="chartNotasPedido"></canvas>
          </div>
        </div>
      </div>

    </div>
  </main>
</div>
</div>

<?php
// Obtener datos para los gráficos
$inventarioKPI = AlmacenController::ctrGetInventarioKPI();
$notasPorSemana = NotaPedidoController::ctrGetNotasPedidoPorSemana();

// Preparar datos de inventario para el gráfico
$inventarioLabels = [];
$inventarioData = [];
$inventarioColors = [];
foreach ($inventarioKPI as $item) {
  $inventarioLabels[] = $item['NombreProducto'];
  $inventarioData[] = (int)$item['CantidadTotal'];
  $inventarioColors[] = $item['CantidadTotal'] >= 0 ? 'rgba(40, 167, 69, 0.8)' : 'rgba(220, 53, 69, 0.8)';
}

// Preparar datos de notas por semana
$notasLabels = [];
$notasData = [];
foreach ($notasPorSemana as $item) {
  // Formatear la fecha de inicio de semana
  $fecha = new DateTime($item['fecha_inicio_semana']);
  $notasLabels[] = $fecha->format('d M');
  $notasData[] = (int)$item['cantidad'];
}
?>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Datos del inventario desde PHP
  const inventarioLabels = <?php echo json_encode($inventarioLabels); ?>;
  const inventarioData = <?php echo json_encode($inventarioData); ?>;
  const inventarioColors = <?php echo json_encode($inventarioColors); ?>;
  
  // Gráfico de Inventario (Barras horizontales)
  const ctxInventario = document.getElementById('chartInventario').getContext('2d');
  new Chart(ctxInventario, {
    type: 'bar',
    data: {
      labels: inventarioLabels,
      datasets: [{
        label: 'Stock',
        data: inventarioData,
        backgroundColor: inventarioColors,
        borderColor: inventarioColors.map(c => c.replace('0.8', '1')),
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const value = context.raw;
              return value >= 0 ? 'Stock: +' + value : 'Stock: ' + value;
            }
          }
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          grid: {
            display: true,
            color: 'rgba(0,0,0,0.1)'
          },
          ticks: {
            callback: function(value) {
              return value;
            }
          }
        },
        y: {
          grid: {
            display: false
          }
        }
      }
    }
  });

  // Datos de notas por semana desde PHP
  const notasLabels = <?php echo json_encode($notasLabels); ?>;
  const notasData = <?php echo json_encode($notasData); ?>;
  
  // Gráfico de Notas de Pedido (Línea)
  const ctxNotas = document.getElementById('chartNotasPedido').getContext('2d');
  new Chart(ctxNotas, {
    type: 'line',
    data: {
      labels: notasLabels,
      datasets: [{
        label: 'Notas de Pedido',
        data: notasData,
        borderColor: 'rgba(0, 123, 255, 1)',
        backgroundColor: 'rgba(0, 123, 255, 0.1)',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 6,
        pointHoverRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: 'top'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Pedidos: ' + context.raw;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0,0,0,0.1)'
          },
          ticks: {
            stepSize: 1,
            callback: function(value) {
              if (Number.isInteger(value)) {
                return value;
              }
            }
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      }
    }
  });
});
</script>
