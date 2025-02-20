import axios from "axios";

document.getElementById("login").addEventListener("submit", (event) => {
    // Prevenir el comportamiento por defecto del formulario
    event.preventDefault();
    document.getElementById("error").className = "d-none";
    // Aquí puedes agregar el código que deseas ejecutar cuando se envíe el formulario
    let correo = event.target["correo"];
    let password = event.target["password"];
  
      
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (emailPattern.test(correo.value) && password.value != "") {
        let datos = { correo: correo.value, password: password.value };
   
        axios
            .post(event.target.action, datos)
            .then((response) => {
               
                console.log(response.data);
                
                if (response.data == "usuario") {
                   window.location.replace(`${event.target['ruta'].value}/usuario`);
                } else if (response.data == "empresa") {
                   window.location.replace(`${event.target['ruta'].value}/empresa`);
                }
            })
            .catch((error) => {
                console.error("Error:", error.response);
                let erroralert = document.getElementById("error");
                erroralert.className = "";
                erroralert.innerText = error.response.data.Error;
            });
    }
});
