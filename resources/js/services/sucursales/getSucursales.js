import axios from "axios";
import config from "../../config/api";

let total = 0;
let pagina = 0;
let tamanopagina = 6;
let getSucursales = async (id) => {
    try {
        let sucursal = `${config.OdataUrl}sucursales?s&$filter=Id_Empresa eq ${id} and Estado eq 'ACTIVO'`;

        if (sucursal != "") {
            let url = `${sucursal}`;

            const response = await axios.get(url);
            return response.data.value;
        }
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
};

function cargarSucursal(id_empresa,idSucursal) {
    getSucursales(id_empresa).then((response) => {
        let slsucursal = document.getElementById(idSucursal);
        if (slsucursal) {
            slsucursal.innerHTML =
                "<option value=''>Seleccione Sucursal</option>";
            response.forEach((element) => {
                const option = document.createElement("option");
                option.value = `${element.Id_Sucursal}`;
                option.innerText = `${element.Sucursal}`;
                slsucursal.append(option);
            });
        }
    });
}

let slempresa = document.getElementById("slempresa");
if (slempresa != null) {
    slempresa.addEventListener("change", (event) => {
        cargarSucursal(event.target.value,"slsucursal");
    });
}

let id_empresa= document.getElementById("idempresa");

if(id_empresa){
    
    let Id_Empresa= JSON.parse(id_empresa.value).Id_Empresa;
    
    cargarSucursal(Id_Empresa,"filsucursal");


}
