import axios from "axios";
import { isEmpty } from "lodash";
let EmpresaUrl = "";
console.log(window.location.search);

if (window.location.search != "") {
    let id = window.location.search.split("=")[1];
    EmpresaUrl = `http://127.0.0.1:8000/odata/Empresas?$filter=(Id_Empresa eq ${id})`;
}


let total = 0;
let pagina = 0;
let tamanopagina = 9;

const getEmpresa = async () => {
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
     let response= await getEmpresa();

     console.log(response[0]);
     if (document.getElementById("empresa")) {

        let form =document.getElementById("empresa");
        form["NomComercial"].value=response[0]['NomComercial'];
        form["RazonSocial"].value=response[0]['RazonSocial'];
        form["GUID"].value=response[0]['GUID'];
        form["Correo"].value=response[0]['Correo'];
        form["Estado"].checked=response[0]['Estado']=="ACTIVO";
        
     }
     
};

cargarData();
