$(document).ready(function () {
    $("#search-input").on("input", function () {
        var searchValue = $(this).val();

        if (searchValue.length < 3) {
            $("#autocomplete-list").hide();
            return;
        }

        $.ajax({
            url: "procesos/autocomplete.php",
            type: "POST",
            data: { search: searchValue },
            success: function (response) {
                if (typeof response === "string") {
                    response = JSON.parse(response);
                }

                if (!response.sugerencias || response.sugerencias.length === 0) {
                    $("#autocomplete-list").html("<p class='list-group-item text-muted'>No hay coincidencias.</p>").show();
                    return;
                }

                var listaHtml = '<ul class="list-group">';
                response.sugerencias.forEach(function (lugar) {
                    listaHtml += `<li class="list-group-item list-group-item-action" data-placeid="${lugar.place_id}">
                                    ${lugar.nombre}
                                  </li>`;
                });
                listaHtml += '</ul>';

                $("#autocomplete-list").html(listaHtml).show();
            },
            error: function (xhr) {
                console.error("Error en la solicitud:", xhr.responseText);
            }
        });
    });

    $("#search-input").on("blur", function () {
        setTimeout(function () {
            $("#autocomplete-list").hide();
        }, 200);
    });

    $(document).on("click", "#autocomplete-list li", function () {
        var placeId = $(this).data("placeid");
        var nombre = $(this).text().trim();

        $("#search-input").val(nombre);
        $("#autocomplete-list").hide();

        buscarLugarPorID(placeId);
    });
});

function buscarLugarPorID(placeId) {
    $.ajax({
        url: 'procesos/search.php',
        type: 'POST',
        data: { place_id: placeId },
        success: function (response) {
            console.log("Detalles de Imagenes",response.imagenes);
            console.log("Detalles del lugar:", response);

            if (typeof response === "string") {
                response = JSON.parse(response);
            }

            if (!response.nombre) {
                alert("No se encontró información del lugar.");
                return;
            }

            var html = '';

            if (response.imagenes.length > 0) {
                html += '<div class="place-images">';
                response.imagenes.forEach(function (imgUrl) {
                    html += `<img src="${imgUrl}" class="img-fluid rounded m-1" style="width: 100px; height: 100px;">`;
                });
                html += '</div>';
            }

            html += `<h4>${response.nombre}</h4>`;
            html += `<p><strong>Dirección:</strong> ${response.direccion}</p>`;

            $('.place-body').html(html);

            $(".review-header").html(`
                <h4>Reseñas</h4>
                <p class="text-muted">Rating: ${response.rating} ⭐ (${response.rating_count} opiniones)</p>
            `);

            if (response.reseñas.length === 0) {
                $(".review-body").html('<p class="text-muted">No hay reseñas disponibles.</p>');
                return;
            }

            var reviewsHtml = "";
            response.reseñas.forEach(function (review) {
                reviewsHtml += `
                    <div class="review-item p-3 mb-3 bg-white rounded shadow-sm">
                        <div class="d-flex align-items-center">
                            <img src="${review.foto_autor}" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <strong>${review.autor}</strong>
                                <p class="text-muted m-0">${review.fecha}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>${review.texto}</p>
                            <p>⭐ ${review.rating}</p>
                        </div>`;

                if (review.imagenes.length > 0) {
                    reviewsHtml += '<div class="review-images mt-2">';
                    review.imagenes.forEach(function (imgUrl) {
                        reviewsHtml += `<img src="${imgUrl}" class="img-fluid rounded m-1" style="width: 80px; height: 80px;">`;
                    });
                    reviewsHtml += '</div>';
                }

                reviewsHtml += `</div>`;
            });

            $(".review-body").html(reviewsHtml);
        },
        error: function (xhr, status, error) {
            console.error("Error en AJAX:", xhr.responseText);
            alert("Hubo un problema con la solicitud.");
        }
    });
}
