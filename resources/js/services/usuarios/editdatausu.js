import axios from "axios";
import { isEmpty } from "lodash";
import config from'../../config/api';
let EmpresaUrl = "";
console.log(window.location.search);

if (window.location.search != "") {
    let id = window.location.search.split("=")[1];
    EmpresaUrl = `${config.OdataUrl}Users?$filter=(Id_Usuario eq ${id})`;
}


let total = 0;
let pagina = 0;
let tamanopagina = 9;

const getusuario = async () => {
    try {
        if (EmpresaUrl != "") {
            const response = await axios.get(`${EmpresaUrl}`);
            return response.data.value;
        }
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
};

const cargarData = async () => {
     let response= await getusuario();

     console.log(response[0]);
     if (document.getElementById("usuario")) {

        let form =document.getElementById("usuario");
        form["Nombre"].value=response[0]['Nombre'];
        form["Correo"].value=response[0]['Correo'];
        form["Admin"].checked=response[0]['Admin'];
        
     }
     
};


if(document.getElementById("usuario")){

    cargarData();

}
