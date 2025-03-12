<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-fluid {
            min-height: 100vh;
            /* Ocupar toda la pantalla */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .row {
            width: 80%;
            max-width: 70%;
            height: 90vh;
            /* Para evitar que toque los bordes */
        }

        .left-side {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .query-container,
        .place-description,
        .review-header,
        .review-body,
        .review-footer {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .review-body {
            height: 65vh;
            overflow-y: auto;
        }

        .place-description {
            flex-grow: 1;
            /* Usa todo el espacio disponible */
            display: flex;
            flex-direction: column;
            /* Evita que se deforme */
        }

        .place-body {
            flex-grow: 1;
            overflow-y: auto;
        }

        .query-input {
            position: relative;
        }

        #autocomplete-list {
            position: absolute;
            width: 100%;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 250px;
            overflow-y: auto;
            display: none;
        }

        #autocomplete-list .list-group-item {
            cursor: pointer;
            padding: 10px;
            border: none;
            transition: background 0.2s;
        }

        #autocomplete-list .list-group-item:hover {
            background: #e9ecef;
        }
    </style>
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
                    <button class="btn btn-primary">Cargar más reseñas</button>
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