import axios from "axios";
import config from "../../config/api";
import DataTable from "datatables.net-dt";
let table = null;
let fechaInicial = "";
let fechaFinal = "";
let sucursal = "";

async function getVentas(url) {
    try {
        console.log(`${config.OdataUrl}ventas?$expand=sucursales${url}`);

        const response = await axios.get(`${config.OdataUrl}ventas?$expand=sucursales${url}`);
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}
function inicializeventasTable(jsonData) {
    try {
        if (table) {
            table.clear().rows.add(jsonData).draw(); // Refresca con nuevos datos sin destruir la instancia
        } else {
            table = new DataTable("#ventastable", {
                data: jsonData,
                columns: [
                    {
                        data: "FechaDoc",
                        render: function (data, type, row) {
                            data = new Date(data);
                          
                            return data.toISOString().split("T")[0];
                        },
                        
                        title: "Fecha",
                    },
                    {
                        data: "sucursal",
                        render: function (data, type, row) {
                            return  row.sucursales.Sucursal
                        },
                        title: "sucursal",
                    },
                    { data: "Cliente", title: "código cliente" },
                    { data: "NombreCliente", title: "Nombre Cliente" },
                    { data: "Importe", title: "Importe" },
                    { data: "Moneda", title: "Moneda" },
                    { data: "Impuesto", title: "Impuesto" },
                    { data: "Total",render: function (data, type, row) {
                            // Calcular el total restando el descuento del importe y sumando el impuesto
                                return row.Importe-row.Descuento+row.Impuesto;               
                           
                    }, title: "Total" },
                ],
                searchable: true, // Activa la búsqueda en la tabla
                sortable: true, // Activa el ordenamiento
                perPage: 5, // Cantidad de elementos por página
            });
        }
    } catch (error) {
        console.error("Error al inicializar DataTable:", error);
    }
}



async function getventasperiodo(event) {
    event.preventDefault();
    fechaInicial = event.target["intialDate"].value;
    fechaFinal = event.target["finalDate"].value;
    sucursal = event.target["sucursal"].value;

    let empresa = JSON.parse(document.getElementById("idempresa").value);
    let periodo = `&$filter=(Id_Empresa eq ${empresa.Id_Empresa})${
        sucursal !== "" ? ` and Id_Sucursal eq ${sucursal}` : ""} ${
        fechaInicial != ""
            ? `and (FechaDoc ge ${new Date(
                  fechaInicial
              ).toISOString()} and FechaDoc le ${new Date(
                  fechaFinal
              ).toISOString()})&$orderby= FechaDoc`
            : ""
    } `;
  
    let response = await getVentas(periodo);
    let jsonData = response.data["value"];
  
    
    inicializeventasTable(jsonData);
}


if (document.getElementById("ventastable") != null) {
    (async () => {
        let response = await getVentas("");
        console.log(response);
        
        let jsonData = response.data["value"];
        inicializeventasTable(jsonData);
       
    })();
}




let exportExcel = async () => {
    console.log(fechaInicial);
    console.log(fechaFinal);
    let url = `${config.apiUrl}ventas/excel/periodo?initialDate=${fechaInicial}&finalDate=${fechaFinal}&sucursal=${sucursal}`;
     window.location.href = url;
};

let exportPdf = async () => {
    console.log(fechaInicial);
    console.log(fechaFinal);
    let url = `${config.apiUrl}ventas/pdf/periodo?initialDate=${fechaInicial}&finalDate=${fechaFinal}&sucursal=${sucursal}`;
     window.location.href = url;
};

let ventasExcel = document.getElementById("ventasExcel");
if (ventasExcel) {
    ventasExcel.addEventListener("click", () => {
        exportExcel();
    });
}

let ventasPdf = document.getElementById("ventaspdf");
if (ventasPdf) {
    ventasPdf.addEventListener("click", () => {
        exportPdf();
    });
}

let formPeriodo = document.getElementById("formPeriodo");
if (formPeriodo != null) {
    formPeriodo.addEventListener("submit", getventasperiodo);
}



