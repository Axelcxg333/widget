<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row g-3 mx-auto">
            <!-- Columna izquierda (más pequeña) -->
            <div class="col-lg-4 col-md-5 d-flex flex-column left-side">
                <div class="query-container mb-3">
                    <h2 class="text-center">Consulta un Lugar</h2>
                    <div class="query-input">
                        <input type="text" id="search-input" class="form-control" placeholder="Buscar lugar...">
                        <div id="autocomplete-list" class="list-group mt-2"></div>
                    </div>
                </div>
                <div class="place-description">
                    <div class="place-header">
                        <h4>Detalles del Lugar</h4>
                    </div>
                    <div class="place-body p-2">
                        <p class="text-muted">Aquí aparecerá la información del lugar seleccionado.</p>
                    </div>
                </div>
            </div>

            <!-- Columna derecha (más grande) -->
            <div class="col-lg-8 col-md-7 d-flex flex-column">
                <div class="review-header">
                    <h4>Reseñas</h4>
                </div>
                <div class="review-body p-3 border bg-light flex-grow-1">
                    <p class="text-muted">Aquí aparecerán las reseñas del lugar.</p>
                </div>
                <div class="review-footer text-center mt-3">
                    <button id="btn-ver-mas" class="btn btn-primary">Ver en Google Maps</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/funciones.js"></script>

</body>

</html>