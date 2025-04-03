
import axios from "axios";
import config from'../../config/api';
let formData = {};

// Captura cambios en los inputs y actualiza formData
function handleChange(event) {
    const { name, value, type, checked } = event.target;
    formData[name] = type === "checkbox" ? checked : value;
    console.log("Datos actuales:", formData);
}

// Función para validar el formulario antes de enviarlo
function validarFormulario(data) {
    let errores = [];

    Object.entries(data).forEach(([key, value]) => {
        if (!value) {
            errores.push(`El campo ${key} es obligatorio.`);
        }
    });

    if (errores.length > 0) {
        console.warn("Errores de validación:", errores);
        alert(errores.join("\n")); // Muestra los errores en una alerta
        return false;
    }

    return true;
}

// Manejo del envío del formulario
function handleSubmit(event) {
    event.preventDefault();

    if (validarFormulario(formData)) {
       let url=event.target.action;

       
    //funcion axios para conectar  por post /api/nuevaSucursal
       
    axios
    .post(url, formData, {
        Headers: {
            "Content-Type": "multipart/form-data",
        },
    })
    .then((response) => {

      if(response.status==200){

          document.getElementById("error").style.display="none";
          event.target.reset();
        }
     
    }) .catch((errores) => {

        document.getElementById("error").style.display="block";


    });
    
        // Aquí puedes enviar los datos con Axios o fetch
    }
}

// Asignar eventos a los elementos si existen
document.addEventListener("DOMContentLoaded", () => {
    const elements = ["slempresa", "Sucursal", "SUID", "Estado"];
    elements.forEach((id) => {
        let element = document.getElementById(id);
        if (element) {
            element.addEventListener("change", handleChange);
        }
    });

    let form = document.getElementById("formsucursal");
    if (form) {
        form.addEventListener("submit", handleSubmit);
    }
});
