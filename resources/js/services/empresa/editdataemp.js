import axios from "axios";
import config from'../../config/api';



let EmpresaUrl = "";


if (window.location.search != "") {
    let id = window.location.search.split("=")[1];
    EmpresaUrl = `${config.OdataUrl}Empresas?$filter=(Id_Empresa eq ${id})`;
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

     if (document.getElementById("empresa")) {
     

        let form =document.getElementById("empresa");
        form["NomComercial"].value=response[0]['NomComercial'];
        form["RazonSocial"].value=response[0]['RazonSocial'];
        form["GUID"].value=response[0]['GUID'];
        form["Correo"].value=response[0]['Correo'];
        form["Estado"].checked=response[0]['Estado']=="ACTIVO";
        
     }
     
};


if (document.getElementById("empresa") && EmpresaUrl) {

    cargarData();

}
