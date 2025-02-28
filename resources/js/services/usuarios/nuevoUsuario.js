function validarFormulario(event) {
    let errors = [];
    event.preventDefault();
    let form = event.target;
    let error = document.getElementById("error");
    error.style.display = "None";
    let exito = document.getElementById("exito");
    exito.style.display = "None";
    let nombre = form["Nombre"].value;
    let correo = form["Correo"].value;
    let Admin = form["Admin"].checked;
    let password = form["password"].value;
    let password2 = form["password2"].value;

    if (!nombre || nombre.trim() === "") {
        errors.push("El nombre completo es obligatorio.");
    }

    if (!correo || correo.trim() === "") {
        errors.push("El correo es obligatorio.");
    } else if (!/\S+@\S+\.\S+/.test(correo)) {
        errors.push("El correo no es válido.");
    }
    if (window.location.search == "") {
        if (!password || password.trim() === "") {
            errors.push("La contraseña es obligatoria.");
        }
        if (password.length < 6) {
            errors.push("La contraseña debe tener al menos 6 caracteres.");
        }
    }
    if (password !== password2) {
        errors.push("Las contraseñas no coinciden");
    }

    if (errors.length > 0) {
        (error.style.display = "block"),
            (error.innerHTML = errors.join("<br>"));
        return;
    }

    let data = {
        Nombre: nombre,
        Clave: password,
        Admin: Admin,
        Correo: correo,
        id:  event.target.id? event.target.id.value:"",
    };

    axios
        .post(event.target.action, data, {
            Headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            console.log(response.status);
            
            if (response.status == 201) {
                
                    event.target.reset();

                    exito.style.display = "block";
                }
                 if (response.status == 200)  {
                     window.location.href = "usuario";
                }
            }
        )
        .catch((errors) => {
            console.error("Error:", errors.response);
            error.style.display = "Block";
            error.innerText = errors.response.statusText;
        });
}

if (document.getElementById("usuario")) {
    document
        .getElementById("usuario")
        .addEventListener("submit", validarFormulario);
}
