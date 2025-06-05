import axios from "axios";
import config from "../../config/api";
import DataTable from "datatables.net-dt";
let table = null;
let month = "";
let anio = "";
let sucursal = "";

async function getVentas(url) {
    try {

        let reqUrl=encodeURI(
                `${config.OdataUrl}ventas?$expand=sucursales${url}`
            )
        console.log(reqUrl);
        
        const response = await axios.get(reqUrl );
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
            table = new DataTable("#mesTable", {
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
                            return row.sucursales.Sucursal;
                        },
                        title: "sucursal",
                    },
                    { data: "Cliente", title: "código cliente" },
                    { data: "NombreCliente", title: "Nombre Cliente" },
                    {
                        data: "Importe",
                        render: (data, type, row) => {
                            let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: row.Moneda.replace("MN","MXN").replace("mx","MXN"), // Puedes cambiar a USD, EUR, etc.
                            });

                            return valor.format(data);
                        },
                        title: "Importe",
                    },
                    { data: "Moneda", title: "Moneda" },
                    {
                        data: "Impuesto",
                        render: (data, type, row) => {
                            let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency:row.Moneda.replace("MN","MXN").replace("mx","MXN"), // Puedes cambiar a USD, EUR, etc.
                            });

                            return valor.format(data);
                        },
                        title: "Impuesto",
                    },
                    {
                        data: "Total",
                        render: function (data, type, row) {
                            // Calcular el total restando el descuento del importe y sumando el impuesto
                            let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: row.Moneda.replace("MN","MXN").replace("mx","MXN"), // Puedes cambiar a USD, EUR, etc.
                            });
                            return valor.format(
                                row.Importe - row.Descuento + row.Impuesto
                            );
                        },
                        title: "Total",
                    },
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

async function getventasMonth(data) {

    console.log(data);
    
    month =data["month"];
    anio = data["anio"];
    sucursal = data["sucursal"];

    let empresa = JSON.parse(document.getElementById("idempresa").value);
    let periodo = `&$filter=(Id_Empresa eq ${empresa.Id_Empresa})${
        sucursal !== "" ? ` and Id_Sucursal eq ${sucursal}` : ""
    }${anio != "" ? ` and year(FechaDoc) eq ${anio}` : ""}${
        month != "" ? ` and month(FechaDoc) eq ${month}&$orderby= FechaDoc` : ""
    } `;

    console.log(periodo);

    let response = await getVentas(periodo);
    let jsonData = response.data["value"];

    inicializeventasTable(jsonData);
}


let exportExcel = async () => {
    let url = `${config.apiUrl}ventas/excel/mes?month=${month}&year=${anio}&sucursal=${sucursal}`;
    window.location.href = url;
};

let exportPdf = async () => {
    let url = encodeURI(
        `${config.apiUrl}ventas/pdf/mes?month=${month}&year=${anio}&sucursal=${sucursal}`
    );
    window.location.href = url;
};

let ventasExcel = document.getElementById("mesExcel");
if (ventasExcel) {
    ventasExcel.addEventListener("click", () => {
        exportExcel();
    });
}

let ventasPdf = document.getElementById("mesPdf");
if (ventasPdf) {
    ventasPdf.addEventListener("click", () => {
        exportPdf();
    });
}

let formMes = document.getElementById("formMes");
if (formMes != null) {

    let hoy =new Date();
   
   formMes["month"].value=hoy.getMonth()+1;
   formMes["anio"].value=hoy.getFullYear();   
    getventasMonth({'month': (hoy.getMonth()+1).toString(),'anio':hoy.getFullYear(),'sucursal':""});
    formMes.addEventListener("submit", (event) => {
        event.preventDefault();
        month = event.target["month"].value;
        anio = event.target["anio"].value;
        sucursal = event.target["sucursal"].value;
       
        getventasMonth({ month,anio,sucursal});
    });
}
