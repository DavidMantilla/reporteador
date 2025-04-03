function fetchEmp(event) {
    event.preventDefault();
    console.log(event);

    let NomComercial = event.target["NomComercial"].value;
    let RazonSocial = event.target["RazonSocial"].value;

    let logotipo = event.target["logotipo"].files[0];
    let GUID = event.target["GUID"].value;
    let Estado = event.target["Estado"].checked ? "ACTIVO" : "INACTIVO";
    let Correo = event.target["Correo"].value;
    let password = event.target["password"].value;
    let password2 = event.target["password2"].value;
    let error = document.getElementById("error");
    error.style.display = "None";
    let exito = document.getElementById("exito");
    exito.style.display = "None";
    let errores = [];

    // Validation
    if (!NomComercial.trim()) {
        errores.push("Nombre Comercial es invalido");
    }
    if (!RazonSocial.trim()) {
        errores.push("Razon Social es invalido");
    }
    if (window.location.search == "") {
        if (!logotipo) {
            errores.push("logotipo es invalido");
        }
    }
    if (!GUID.trim()) {
        errores.push("GUID es invalido");
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!Correo.trim() || !emailPattern.test(Correo)) {
        errores.push("Correo es invalido");
    }
    if (window.location.search == "") {
        if (!password.trim()) {
            errores.push("Contraseña es invalido");
        }
        if (password.length < 6) {
            errores.push("La contraseña debe tener al menos 6 caracteres.");
        }
    }

    if (password !== password2.trim()) {
        errores.push("Las contraseñas no coinciden");
    }

    if (errores.length > 0) {
        error.innerHTML = errores.join("<br>");
        error.style.display = "Block";
        return;
    }

    let formData = new FormData(event.target);
    formData.append("NomComercial", event.target["NomComercial"].value);
    formData.append("RazonSocial", event.target["RazonSocial"].value);
    formData.append("logotipo", event.target["logotipo"].files[0]);
    formData.append("GUID", event.target["GUID"].value);
    formData.append("Estado", Estado);
    formData.append("Correo", event.target["Correo"].value);
    if (event.target.id) formData.append("id", event.target.id.value);
    formData.append("password", event.target["password"].value);
   
    axios
        .post(event.target.action, formData, {
            Headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            if (response) {
                if (window.location.search == "") {
                    event.target.reset();

                    exito.style.display = "block";
                } else {
                    window.location.href = "usuario";
                }
            }
        })
        .catch((errores) => {
            console.error("Error:", errores.response);
            error.style.display = "Block";
            error.innerText = errores.response.statusText;
        });
}

if (document.getElementById("empresa")) {
    document.getElementById("empresa").addEventListener("submit", fetchEmp);
}
