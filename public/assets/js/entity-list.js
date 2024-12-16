"use strict";

const deleteEntity = (routePath, csrfToken) => {
    const swal = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-secondary me-2"
        },
        buttonsStyling: false
    });

    swal.fire({
        title: 'Êtes-vous sûr de supprimer ?',
        text: 'Cette action est irréversible',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            fetch(routePath, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    _token: csrfToken
                })
            }).then(response => {
                if (!response.ok) throw new Error("La suppression a échoué");

                swal.fire({
                    title: "Supprimé !",
                    text: "L'élément a été supprimé avec succès",
                    icon: "success",
                    confirmButtonText: "Continuer"
                }).then(() => {
                    document.location.reload();
                });
            }).catch(error => {
                swal.fire("Une erreur s'est produite", error.message, "error");
            })
        }
        else if (result.dismiss === Swal.DismissReason.cancel) Swal.close();
    });
};

const showSuccessFulToast = (message) => {
    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    toast.fire({
        icon: 'success',
        title: message
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll(".btn-delete");

    if (deleteButtons && deleteButtons.length > 0)
        deleteButtons.forEach(deleteButton => {
            deleteButton.addEventListener("click", () => {
                const routePath = deleteButton.getAttribute("data-route");
                const csrfToken = deleteButton.getAttribute("data-token");

                if (routePath && csrfToken)
                    deleteEntity(routePath, csrfToken);
            });
        });
});
