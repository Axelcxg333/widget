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

    });
});