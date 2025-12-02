document.addEventListener("DOMContentLoaded", () => {

    window.addEventListener("timeSelected", () => {
        document.getElementById("notification-area").innerHTML = `
            <div class="alert alert-success fw-bold">
                ✔ Hora seleccionada correctamente
            </div>
        `;
    });

});
